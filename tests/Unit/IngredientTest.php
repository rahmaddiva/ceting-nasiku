<?php

namespace Tests\Unit;

use App\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IngredientTest extends TestCase
{
    use RefreshDatabase;

    public function test_substitutes_returns_group_members_excluding_self(): void
    {
        $bayam = Ingredient::create(['name' => 'Bayam', 'unit' => 'gram', 'substitution_group' => 'sayur-hijau']);
        $sawi = Ingredient::create(['name' => 'Sawi', 'unit' => 'gram', 'substitution_group' => 'sayur-hijau']);
        $kelor = Ingredient::create(['name' => 'Daun Kelor', 'unit' => 'gram', 'substitution_group' => 'sayur-hijau']);
        $beras = Ingredient::create(['name' => 'Beras Putih', 'unit' => 'gram']);

        $subs = $bayam->substitutes();

        $this->assertCount(2, $subs);
        $this->assertTrue($subs->pluck('id')->doesntContain($bayam->id));
        $this->assertTrue($subs->pluck('id')->contains($sawi->id));
        $this->assertTrue($subs->pluck('id')->contains($kelor->id));
        $this->assertTrue($subs->pluck('id')->doesntContain($beras->id));
    }

    public function test_substitutes_returns_empty_when_ingredient_has_no_group(): void
    {
        $ing = Ingredient::create(['name' => 'Beras Putih', 'unit' => 'gram']);

        $this->assertTrue($ing->substitutes()->isEmpty());
    }
}
