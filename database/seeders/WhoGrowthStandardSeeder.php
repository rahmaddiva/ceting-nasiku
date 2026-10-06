<?php

namespace Database\Seeders;

use App\Models\GrowthStandard;
use Illuminate\Database\Seeder;

/**
 * Seed data standar pertumbuhan WHO Child Growth Standards (LMS method, 0-59 bulan).
 *
 * Sumber data (nilai L/M/S resmi WHO):
 *  - Length-for-age (0-24 bln) & Height-for-age (24-60 bln): ericpgreen/WHO-growth-charts
 *    (mirror dari tabel resmi WHO, tervalidasi silang dengan file CDC WHO 0-24 bln).
 */
class WhoGrowthStandardSeeder extends Seeder
{
    private const FILES = [
        'lfa-b-z.csv' => ['male', 'height_for_age', 0, 23],
        'lfa-g-z.csv' => ['female', 'height_for_age', 0, 23],
        'hfa-b-z.csv' => ['male', 'height_for_age', 24, 59],
        'hfa-g-z.csv' => ['female', 'height_for_age', 24, 59],
        'wfa-b-z.csv' => ['male', 'weight_for_age', 0, 59],
        'wfa-g-z.csv' => ['female', 'weight_for_age', 0, 59],
    ];

    public function run(): void
    {
        GrowthStandard::query()->delete();

        $rows = [];

        foreach (self::FILES as $file => [$sex, $indicator, $minMonth, $maxMonth]) {
            $path = database_path('data/who/'.$file);

            if (! file_exists($path)) {
                $this->command->warn("Data WHO tidak ditemukan: {$path}");

                continue;
            }

            // Normalisasi line ending (file sumber ada yang memakai CR-only).
            $content = preg_replace('/\r\n?/', "\n", (string) file_get_contents($path));

            $first = true;

            foreach (explode("\n", $content) as $line) {
                if (trim($line) === '') {
                    continue;
                }

                if ($first) {
                    $first = false;

                    continue;
                }

                $fields = str_getcsv($line);

                if (count($fields) < 4) {
                    continue;
                }

                $month = (int) trim($fields[0]);

                if ($month < $minMonth || $month > $maxMonth) {
                    continue;
                }

                $rows[] = [
                    'sex' => $sex,
                    'indicator' => $indicator,
                    'age_months' => $month,
                    'l' => (float) trim($fields[1]),
                    'm' => (float) trim($fields[2]),
                    's' => (float) trim($fields[3]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        GrowthStandard::insert($rows);

        $this->command->info('Growth standards seeded: '.count($rows).' baris (LMS WHO 0-59 bulan).');
    }
}
