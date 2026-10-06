<?php

namespace App\Services;

use App\Models\Child;
use App\Models\ChildMeasurement;
use App\Models\GrowthStandard;

/**
 * Perhitungan z-score pertumbuhan anak berdasarkan standar WHO
 * (Child Growth Standards, LMS method, usia 0-59 bulan).
 */
class GrowthCalculator
{
    public const INDICATOR_HEIGHT_FOR_AGE = 'height_for_age';

    public const INDICATOR_WEIGHT_FOR_AGE = 'weight_for_age';

    /**
     * Cache L/M/S per "sex|indicator|month" selama satu request.
     * Seluruh tabel standar hanya 240 baris (2 sex x 2 indikator x 60 bulan),
     * jadi sekali load sudah cukup untuk semua perhitungan z-score & kurva.
     *
     * @var array<string, GrowthStandard>|null
     */
    private ?array $standards = null;

    /**
     * Ambil parameter L/M/S standar WHO untuk usia (bulan) tertentu.
     * Usia dibulatkan ke bawah (completed months) dan di-clamp 0-59.
     */
    public function standard(string $sex, string $indicator, int $ageMonths): ?GrowthStandard
    {
        $month = min(max($ageMonths, 0), 59);

        return $this->standards()[$sex.'|'.$indicator.'|'.$month] ?? null;
    }

    /**
     * Muat (lazy) dan cache seluruh tabel standar sebagai array.
     *
     * @return array<string, GrowthStandard>
     */
    private function standards(): array
    {
        if ($this->standards === null) {
            $this->standards = GrowthStandard::query()
                ->get()
                ->keyBy(fn (GrowthStandard $s) => $s->sex.'|'.$s->indicator.'|'.$s->age_months)
                ->all();
        }

        return $this->standards;
    }

    /**
     * Hitung z-score sebuah nilai pengukuran (LMS method).
     * Kembalikan null jika standar tidak tersedia atau nilai tidak valid.
     */
    public function zScore(string $sex, string $indicator, int $ageMonths, ?float $value): ?float
    {
        if ($value === null || $value <= 0) {
            return null;
        }

        $std = $this->standard($sex, $indicator, $ageMonths);

        if (! $std || $std->s <= 0) {
            return null;
        }

        $ratio = $value / $std->m;

        if (abs($std->l) < 1e-9) {
            $z = log($ratio) / $std->s;
        } else {
            $z = (pow($ratio, $std->l) - 1) / ($std->l * $std->s);
        }

        return round($z, 2);
    }

    /**
     * Nilai pengukuran untuk z-score tertentu (kebalikan LMS).
     * X = M(1 + LSZ)^(1/L), atau X = M·exp(S·Z) saat L = 0.
     */
    public function valueForZ(string $sex, string $indicator, int $ageMonths, float $z): ?float
    {
        $std = $this->standard($sex, $indicator, $ageMonths);

        return $std === null ? null : $this->valueFromStandard($std, $z);
    }

    /**
     * Kebalikan LMS dari parameter standar yang sudah diambil.
     * Dipisah agar pemanggil kurva bisa reuse satu lookup per bulan.
     */
    private function valueFromStandard(GrowthStandard $std, float $z): float
    {
        if (abs($std->l) < 1e-9) {
            return round($std->m * exp($std->s * $z), 2);
        }

        return round($std->m * pow(1 + $std->l * $std->s * $z, 1 / $std->l), 2);
    }

    /**
     * Kurva referensi nilai pengukuran untuk 0..maxMonth pada beberapa level z.
     * Satu lookup standar per bulan, dipakai ulang untuk semua level z.
     *
     * @param  array<int, float|int>  $zLevels
     * @return array<float|int, array<int, float|null>>
     */
    public function curve(string $sex, string $indicator, int $maxMonth, array $zLevels): array
    {
        $curve = array_fill_keys($zLevels, []);

        for ($month = 0; $month <= $maxMonth; $month++) {
            $std = $this->standard($sex, $indicator, $month);

            foreach ($zLevels as $z) {
                $curve[$z][] = $std === null ? null : $this->valueFromStandard($std, (float) $z);
            }
        }

        return $curve;
    }

    /**
     * Status TB/U (height-for-age) berdasarkan z-score.
     */
    public function classifyHeight(float $z): array
    {
        if ($z < -3) {
            return ['status' => 'Sangat Pendek (Stunting Berat)', 'level' => 'severe', 'suggestion' => 'Segera bawa anak ke puskesmas/posyandu untuk pemeriksaan dan penanganan lebih lanjut oleh tenaga kesehatan.'];
        }

        if ($z < -2) {
            return ['status' => 'Pendek (Stunting)', 'level' => 'stunting', 'suggestion' => 'Ajak anak ke posyandu/puskesmas untuk pemantauan. Perbaiki asupan protein hewani (ikan, telur, hati) dan pola makan bergizi seimbang.'];
        }

        return ['status' => 'Normal', 'level' => 'normal', 'suggestion' => 'Pertumbuhan tinggi badan anak baik. Lanjutkan pemberian makanan bergizi dan pantau rutin setiap bulan.'];
    }

    /**
     * Status BB/U (weight-for-age) berdasarkan z-score.
     */
    public function classifyWeight(float $z): array
    {
        if ($z < -3) {
            return ['status' => 'Gizi Buruk', 'level' => 'severe', 'suggestion' => 'Segera konsultasikan ke puskesmas/tenaga gizi. Anak gizi buruk membutuhkan penanganan medis segera.'];
        }

        if ($z < -2) {
            return ['status' => 'Gizi Kurang', 'level' => 'stunting', 'suggestion' => 'Tingkatkan asupan kalori dan protein sesuai usia. Berikan MPASI kaya protein hewani dan pantau berat badan bulanan.'];
        }

        return ['status' => 'Normal', 'level' => 'normal', 'suggestion' => 'Berat badan anak sesuai standar. Pertahankan pola makan bergizi dan timbang rutin tiap bulan.'];
    }

    /**
     * Status lengkap satu pengukuran (TB/U dan BB/U bila data tersedia).
     */
    public function statusFor(Child $child, ChildMeasurement $measurement): array
    {
        $ageMonths = $child->ageInMonthsAt($measurement->measured_at);

        $result = ['age_months' => $ageMonths];

        if ($measurement->height_cm !== null) {
            $z = $this->zScore($child->gender, self::INDICATOR_HEIGHT_FOR_AGE, $ageMonths, $measurement->height_cm);
            $result['height'] = $z === null
                ? ['z' => null, 'classify' => null]
                : ['z' => $z, 'classify' => $this->classifyHeight($z)];
        }

        if ($measurement->weight_kg !== null) {
            $z = $this->zScore($child->gender, self::INDICATOR_WEIGHT_FOR_AGE, $ageMonths, $measurement->weight_kg);
            $result['weight'] = $z === null
                ? ['z' => null, 'classify' => null]
                : ['z' => $z, 'classify' => $this->classifyWeight($z)];
        }

        return $result;
    }
}
