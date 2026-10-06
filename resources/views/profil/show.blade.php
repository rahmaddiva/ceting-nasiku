@extends('layouts.public')
@section('body_class', 'page-inner')
@section('title', 'Tumbuh Kembang '.$child->name.' — CETING NASIKU')

@section('content')
<div style="padding-top: 6rem;">
    <div class="container">

        <!-- Header anak -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: var(--primary-50); color: var(--primary-700); display: flex; align-items: center; justify-content: center; font-size: 1.6rem;">
                    <i class="fas fa-{{ $child->gender === 'female' ? 'person-dress' : 'person' }}"></i>
                </div>
                <div>
                    <h1 style="color: var(--primary-900); margin: 0; font-size: 1.8rem;">{{ $child->name }}</h1>
                    <span style="color: var(--text-muted); font-size: 0.9rem;">
                        {{ $child->gender === 'female' ? 'Perempuan' : 'Laki-laki' }} • Lahir {{ $child->birth_date->format('d M Y') }} • {{ $child->ageInMonths() }} bulan
                    </span>
                </div>
            </div>
            <a href="{{ route('profil.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Semua Anak</a>
        </div>

        @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
        </div>
        @endif

        <!-- Status terbaru -->
        @php
            $latestRow = $rows->last();
            $latest = $latestRow['status'] ?? null;
            $h = $latest['height']['classify'] ?? null;
            $hz = $latest['height']['z'] ?? null;
            $w = $latest['weight']['classify'] ?? null;
            $wz = $latest['weight']['z'] ?? null;
            $hColors = ['normal' => ['bg' => '#ecfdf5', 'text' => 'var(--accent-700)', 'icon' => 'check-circle'], 'stunting' => ['bg' => '#fffbeb', 'text' => '#92400e', 'icon' => 'triangle-exclamation'], 'severe' => ['bg' => '#fef2f2', 'text' => '#991b1b', 'icon' => 'circle-exclamation']];
            $wColors = ['normal' => ['bg' => '#ecfdf5', 'text' => 'var(--accent-700)', 'icon' => 'check-circle'], 'stunting' => ['bg' => '#fffbeb', 'text' => '#92400e', 'icon' => 'triangle-exclamation'], 'severe' => ['bg' => '#fef2f2', 'text' => '#991b1b', 'icon' => 'circle-exclamation']];
        @endphp


        @if($latest)
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
            @if($h)
            <div style="background: #fff; border: 1px solid var(--primary-100); border-left: 5px solid {{ $hColors[$h['level']]['text'] }}; border-radius: 12px; padding: 1rem 1.25rem;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <strong style="color: var(--primary-900);">Tinggi Badan / Umur</strong>
                    <span style="color: var(--text-muted); font-size: 0.8rem;">Z-score {{ $hz !== null ? number_format($hz, 2) : '-' }}</span>
                </div>
                <div style="margin-top: 0.5rem;">
                    <span style="background: {{ $hColors[$h['level']]['bg'] }}; color: {{ $hColors[$h['level']]['text'] }}; font-weight: 700; font-size: 0.82rem; padding: 0.4rem 0.9rem; border-radius: 999px;"><i class="fas fa-{{ $hColors[$h['level']]['icon'] }}"></i> {{ $h['status'] }}</span>
                </div>
                <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0.6rem 0 0;">{{ $h['suggestion'] }}</p>
            </div>
            @endif
            @if($w)
            <div style="background: #fff; border: 1px solid var(--primary-100); border-left: 5px solid {{ $wColors[$w['level']]['text'] }}; border-radius: 12px; padding: 1rem 1.25rem;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <strong style="color: var(--primary-900);">Berat Badan / Umur</strong>
                    <span style="color: var(--text-muted); font-size: 0.8rem;">Z-score {{ $wz !== null ? number_format($wz, 2) : '-' }}</span>
                </div>
                <div style="margin-top: 0.5rem;">
                    <span style="background: {{ $wColors[$w['level']]['bg'] }}; color: {{ $wColors[$w['level']]['text'] }}; font-weight: 700; font-size: 0.82rem; padding: 0.4rem 0.9rem; border-radius: 999px;"><i class="fas fa-{{ $wColors[$w['level']]['icon'] }}"></i> {{ $w['status'] }}</span>
                </div>
                <p style="font-size: 0.82rem; color: var(--text-muted); margin: 0.6rem 0 0;">{{ $w['suggestion'] }}</p>
            </div>
            @endif
            @if($child->ageInMonths() > 59)
            <div style="background: #fffbeb; border: 1px solid var(--warning); border-radius: 12px; padding: 1rem 1.25rem; color: #92400e; font-size: 0.9rem;">
                <i class="fas fa-circle-info"></i> Usia anak sudah melewati rentang standar WHO (0-59 bulan). Status di atas berdasarkan pengukuran terakhir dalam rentang tersebut.
            </div>
            @endif
        </div>
        @endif

            <!-- Form pengukuran -->
            <div style="background: #fff; border: 1px solid var(--primary-100); border-radius: 16px; padding: 1.5rem; box-shadow: 0 2px 12px rgba(8,145,178,.07);">
                <h2 style="color: var(--primary-900); font-size: 1.2rem; margin-bottom: 1rem;"><i class="fas fa-weight-scale" style="color: var(--primary-600);"></i> Catat Pengukuran</h2>
                <form action="{{ route('profil.children.measurements.store', $child) }}" method="POST" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; align-items: end;">
                    @csrf
                    <div class="form-group" style="margin: 0;">
                        <label for="measured_at">Tanggal *</label>
                        <input type="date" name="measured_at" id="measured_at" class="form-control" value="{{ old('measured_at', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" min="{{ $child->birth_date->format('Y-m-d') }}" required>
                    </div>
                    <div class="form-group" style="margin: 0;">
                        <label for="weight_kg">Berat Badan (kg)</label>
                        <input type="number" name="weight_kg" id="weight_kg" class="form-control" value="{{ old('weight_kg') }}" min="0" max="200" step="0.01" placeholder="cth: 12.5">
                    </div>
                    <div class="form-group" style="margin: 0;">
                        <label for="height_cm">Tinggi Badan (cm)</label>
                        <input type="number" name="height_cm" id="height_cm" class="form-control" value="{{ old('height_cm') }}" min="0" max="250" step="0.1" placeholder="cth: 85.5">
                    </div>
                    <div class="form-group" style="margin: 0;">
                        <label for="note">Catatan</label>
                        <input type="text" name="note" id="note" class="form-control" value="{{ old('note') }}" maxlength="255" placeholder="opsional">
                    </div>
                    <button type="submit" class="btn btn-primary" style="justify-content: center;"><i class="fas fa-plus"></i> Simpan</button>
                </form>
                <p style="font-size: 0.78rem; color: var(--text-muted); margin-top: 0.75rem;">Isi minimal salah satu: berat badan atau tinggi badan.</p>
            </div>

            <!-- Grafik -->
            @if($chart['height_for_age']['points']->isNotEmpty() || $chart['weight_for_age']['points']->isNotEmpty())
            <div style="background: #fff; border: 1px solid var(--primary-100); border-radius: 16px; padding: 1.5rem; box-shadow: 0 2px 12px rgba(8,145,178,.07);">
                <h2 style="color: var(--primary-900); font-size: 1.2rem; margin-bottom: 0.25rem;"><i class="fas fa-chart-line" style="color: var(--primary-600);"></i> Kurva Pertumbuhan WHO</h2>
                <p style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 1rem;">Garis: median (hijau), -2 SD (kuning), -3 SD (merah). Titik biru = pengukuran anak.</p>
                <div style="height: 320px; margin-bottom: 1.5rem;"><canvas id="heightChart"></canvas></div>
                <div style="height: 320px;"><canvas id="weightChart"></canvas></div>
            </div>
            @endif

            <!-- Riwayat -->
            @if($rows->isNotEmpty())
            <div style="background: #fff; border: 1px solid var(--primary-100); border-radius: 16px; padding: 1.5rem; box-shadow: 0 2px 12px rgba(8,145,178,.07);">
                <h2 style="color: var(--primary-900); font-size: 1.2rem; margin-bottom: 1rem;"><i class="fas fa-clock-rotate-left" style="color: var(--primary-600);"></i> Riwayat Pengukuran</h2>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                        <thead>
                            <tr style="text-align: left; color: var(--text-muted); font-size: 0.8rem; border-bottom: 2px solid var(--primary-100);">
                                <th style="padding: 0.6rem 0.5rem;">Tanggal</th>
                                <th style="padding: 0.6rem 0.5rem;">Umur</th>
                                <th style="padding: 0.6rem 0.5rem;">BB (kg)</th>
                                <th style="padding: 0.6rem 0.5rem;">TB (cm)</th>
                                <th style="padding: 0.6rem 0.5rem;">Status TB/U</th>
                                <th style="padding: 0.6rem 0.5rem;">Status BB/U</th>
                                <th style="padding: 0.6rem 0.5rem;">Catatan</th>
                                <th style="padding: 0.6rem 0.5rem;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows->reverse() as $row)
                            @php
                                $m = $row['measurement'];
                                $s = $row['status'];
                                $h2 = $s['height']['classify'] ?? null;
                                $w2 = $s['weight']['classify'] ?? null;
                            @endphp
                            <tr style="border-bottom: 1px solid var(--gray-100);">
                                <td style="padding: 0.7rem 0.5rem;">{{ $m->measured_at->format('d M Y') }}</td>
                                <td style="padding: 0.7rem 0.5rem;">{{ $s['age_months'] }} bln</td>
                                <td style="padding: 0.7rem 0.5rem;">{{ $m->weight_kg !== null ? number_format($m->weight_kg, 2) : '-' }}</td>
                                <td style="padding: 0.7rem 0.5rem;">{{ $m->height_cm !== null ? number_format($m->height_cm, 1) : '-' }}</td>
                                <td style="padding: 0.7rem 0.5rem;">
                                    @if($h2)
                                    <span style="background: {{ $hColors[$h2['level']]['bg'] }}; color: {{ $hColors[$h2['level']]['text'] }}; font-weight: 600; font-size: 0.75rem; padding: 0.25rem 0.6rem; border-radius: 999px;">{{ $h2['status'] }}</span>
                                    @else<span style="color: var(--text-muted);">-</span>@endif
                                </td>
                                <td style="padding: 0.7rem 0.5rem;">
                                    @if($w2)
                                    <span style="background: {{ $wColors[$w2['level']]['bg'] }}; color: {{ $wColors[$w2['level']]['text'] }}; font-weight: 600; font-size: 0.75rem; padding: 0.25rem 0.6rem; border-radius: 999px;">{{ $w2['status'] }}</span>
                                    @else<span style="color: var(--text-muted);">-</span>@endif
                                </td>
                                <td style="padding: 0.7rem 0.5rem; color: var(--text-muted);">{{ $m->note ?? '-' }}</td>
                                <td style="padding: 0.7rem 0.5rem; text-align: right;">
                                    <form action="{{ route('profil.measurements.destroy', $m) }}" method="POST" onsubmit="return confirm('Hapus pengukuran ini?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="border: none; background: none; color: #dc2626; cursor: pointer; font-size: 0.9rem;" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function () {
    const CHART = @json($chart);

    function lineDataset(label, data, color, dash) {
        return {
            label: label,
            data: data,
            borderColor: color,
            backgroundColor: color,
            borderWidth: 2,
            borderDash: dash || [],
            pointRadius: 0,
            fill: false,
            tension: 0.3,
        };
    }

    function renderChart(canvasId, indicator, yLabel, unit) {
        const el = document.getElementById(canvasId);
        if (!el) return;
        const c = CHART[indicator];
        if (!c) return;

        const datasets = [
            lineDataset('Median (0 SD)', c.sd0, 'var(--accent-600)'),
            lineDataset('-2 SD', c.sd2neg, 'var(--warning)', [6, 4]),
            lineDataset('-3 SD', c.sd3neg, '#dc2626', [6, 4]),
        ];

        if (c.points.length) {
            datasets.push({
                label: 'Pengukuran anak',
                data: c.points,
                borderColor: 'var(--primary-600)',
                backgroundColor: 'var(--primary-600)',
                pointRadius: 5,
                pointHoverRadius: 7,
                showLine: false,
            });
        }

        new Chart(el, {
            type: 'line',
            data: { labels: c.months, datasets: datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                scales: {
                    x: {
                        title: { display: true, text: 'Usia (bulan)' },
                        ticks: { stepSize: 6 }
                    },
                    y: {
                        title: { display: true, text: yLabel + ' (' + unit + ')' }
                    }
                },
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    renderChart('heightChart', 'height_for_age', 'Tinggi Badan', 'cm');
    renderChart('weightChart', 'weight_for_age', 'Berat Badan', 'kg');
})();
</script>
@endsection
