<?php

namespace Tests\Unit;

use App\Services\GrowthCalculator;
use Database\Seeders\WhoGrowthStandardSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GrowthCalculatorTest extends TestCase
{
    use RefreshDatabase;

    private GrowthCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(WhoGrowthStandardSeeder::class);
        $this->calculator = app(GrowthCalculator::class);
    }

    public function test_value_at_median_scores_zero(): void
    {
        $z = $this->calculator->zScore('male', 'height_for_age', 24, 87.1161);

        $this->assertEquals(0, $z);
    }

    public function test_z_score_matches_known_value(): void
    {
        // Anak laki-laki 9 bulan, 9.7 kg (L=0.0917, M=8.9014, S=0.10881) -> Z ≈ 0.79
        $z = $this->calculator->zScore('male', 'weight_for_age', 9, 9.7);

        $this->assertNotNull($z);
        $this->assertEqualsWithDelta(0.79, $z, 0.01);
    }

    public function test_value_for_z_round_trips_to_z_score(): void
    {
        $value = $this->calculator->valueForZ('female', 'height_for_age', 36, -2);

        $this->assertNotNull($value);
        $z = $this->calculator->zScore('female', 'height_for_age', 36, $value);
        $this->assertEqualsWithDelta(-2, $z, 0.01);
    }

    public function test_age_out_of_range_is_clamped_to_standards(): void
    {
        // 100 bulan -> clamp 59; median 59 bulan harus menghasilkan z=0
        $z = $this->calculator->zScore('male', 'height_for_age', 100, 109.417);

        $this->assertEquals(0, $z);
    }

    public function test_height_classification_boundaries(): void
    {
        $this->assertSame('normal', $this->calculator->classifyHeight(-1.99)['level']);
        $this->assertSame('stunting', $this->calculator->classifyHeight(-2.01)['level']);
        $this->assertSame('stunting', $this->calculator->classifyHeight(-2.5)['level']);
        $this->assertSame('severe', $this->calculator->classifyHeight(-3.01)['level']);
    }

    public function test_weight_classification_boundaries(): void
    {
        $this->assertSame('normal', $this->calculator->classifyWeight(-1.99)['level']);
        $this->assertSame('stunting', $this->calculator->classifyWeight(-2.01)['level']);
        $this->assertSame('severe', $this->calculator->classifyWeight(-3.5)['level']);
    }

    public function test_invalid_value_returns_null(): void
    {
        $this->assertNull($this->calculator->zScore('male', 'weight_for_age', 12, 0));
        $this->assertNull($this->calculator->zScore('male', 'weight_for_age', 12, -5));
        $this->assertNull($this->calculator->zScore('male', 'weight_for_age', 12, null));
    }

    public function test_curve_matches_value_for_z_for_every_month_and_level(): void
    {
        $levels = [-3, -2, 0];
        $curve = $this->calculator->curve('female', 'height_for_age', 59, $levels);

        $this->assertSame($levels, array_keys($curve));

        foreach ($levels as $z) {
            $this->assertCount(60, $curve[$z]);

            for ($month = 0; $month <= 59; $month++) {
                $this->assertSame(
                    $this->calculator->valueForZ('female', 'height_for_age', $month, $z),
                    $curve[$z][$month],
                    "Kurva tidak konsisten pada z={$z}, bulan={$month}"
                );
            }
        }
    }
}
