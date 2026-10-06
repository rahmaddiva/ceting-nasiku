<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\ChildMeasurement;
use App\Services\GrowthCalculator;
use Illuminate\Http\Request;

class ChildGrowthController extends Controller
{
    public function __construct(private GrowthCalculator $calculator) {}

    public function index()
    {
        $children = auth()->user()->children()
            ->with('measurements')
            ->get()
            ->map(function (Child $child) {
                $latest = $child->measurements->last();

                return [
                    'child' => $child,
                    'latest' => $latest ? $this->calculator->statusFor($child, $latest) : null,
                ];
            });

        return view('profil.index', compact('children'));
    }

    public function create()
    {
        return view('profil.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date|before_or_equal:today|after:2000-01-01',
        ]);

        auth()->user()->children()->create($data);

        return redirect()->route('profil.index')
            ->with('success', 'Data anak berhasil ditambahkan. Mulai catat pengukuran pertama.');
    }

    public function show(Child $child)
    {
        abort_unless($child->user_id === auth()->id(), 403);

        $measurements = $child->measurements()->get();

        $rows = $measurements->map(fn (ChildMeasurement $m) => [
            'measurement' => $m,
            'status' => $this->calculator->statusFor($child, $m),
        ]);

        $chart = $this->chartData($child, $measurements);

        return view('profil.show', compact('child', 'rows', 'chart'));
    }

    public function storeMeasurement(Request $request, Child $child)
    {
        abort_unless($child->user_id === auth()->id(), 403);

        $data = $request->validate([
            'measured_at' => 'required|date|before_or_equal:today|after_or_equal:'.$child->birth_date->toDateString(),
            'weight_kg' => 'nullable|numeric|min:0|max:200',
            'height_cm' => 'nullable|numeric|min:0|max:250',
            'note' => 'nullable|string|max:255',
        ]);

        if (empty($data['weight_kg']) && empty($data['height_cm'])) {
            return back()->withErrors(['weight_kg' => 'Isi minimal berat badan atau tinggi badan.'])
                ->withInput();
        }

        $child->measurements()->create($data);

        return back()->with('success', 'Pengukuran berhasil dicatat.');
    }

    public function destroyMeasurement(ChildMeasurement $measurement)
    {
        abort_unless($measurement->child->user_id === auth()->id(), 403);

        $measurement->delete();

        return back()->with('success', 'Pengukuran berhasil dihapus.');
    }

    /**
     * Data kurva referensi WHO (median, -2SD, -3SD) + titik pengukuran anak.
     */
    private function chartData(Child $child, $measurements): array
    {
        $maxAge = max(60, $child->ageInMonths());
        $months = range(0, $maxAge);
        $zLevels = [-3, -2, 0];
        $chart = [];

        foreach (['height_for_age', 'weight_for_age'] as $indicator) {
            $field = $indicator === 'height_for_age' ? 'height_cm' : 'weight_kg';

            // Satu lookup standar per bulan, dipakai ulang untuk ketiga level z.
            $curves = $this->calculator->curve($child->gender, $indicator, $maxAge, $zLevels);

            $chart[$indicator] = [
                'months' => $months,
                'sd3neg' => $curves[-3],
                'sd2neg' => $curves[-2],
                'sd0' => $curves[0],
                'points' => $measurements
                    ->filter(fn ($m) => $m->{$field} !== null)
                    ->map(fn ($m) => [
                        'x' => $child->ageInMonthsAt($m->measured_at),
                        'y' => (float) $m->{$field},
                    ])
                    ->values(),
            ];
        }

        return $chart;
    }
}
