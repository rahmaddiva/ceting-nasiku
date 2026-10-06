<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeSubstitutionTest extends TestCase
{
    use RefreshDatabase;

    private function makeRecipe(array $ingredients): Recipe
    {
        $category = Category::create(['name' => 'Balita 1-3 Tahun', 'slug' => 'balita-1-3-tahun']);
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.dev',
            'password' => bcrypt('secret'),
            'role' => 'admin',
        ]);

        $recipe = Recipe::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Sayur Bening Test',
            'slug' => 'sayur-bening-test',
            'description' => 'Sayur bening untuk tes substitusi bahan.',
            'instructions' => "1. Rebus air\n2. Masukkan sayur",
            'servings' => 2,
            'age_group' => '1-3 tahun',
            'is_published' => true,
        ]);

        $recipe->ingredients()->attach(collect($ingredients)->mapWithKeys(
            fn ($grams, $name) => [$name => ['quantity_grams' => $grams]]
        ));

        return $recipe;
    }

    public function test_recipe_show_page_displays_substitution_options(): void
    {
        $bayam = Ingredient::create(['name' => 'Bayam', 'unit' => 'gram', 'calories' => 23, 'substitution_group' => 'sayur-hijau']);
        $sawi = Ingredient::create(['name' => 'Sawi', 'unit' => 'gram', 'calories' => 28, 'substitution_group' => 'sayur-hijau']);
        $kelor = Ingredient::create(['name' => 'Daun Kelor', 'unit' => 'gram', 'calories' => 64, 'substitution_group' => 'sayur-hijau']);
        $beras = Ingredient::create(['name' => 'Beras Putih', 'unit' => 'gram']);

        $recipe = $this->makeRecipe([$bayam->id => 20, $beras->id => 50]);

        $response = $this->get('/resep/'.$recipe->slug);

        $response->assertOk();
        $response->assertSee('Ganti:');
        $response->assertSee('Sawi');
        $response->assertSee('Daun Kelor');
        $response->assertSee('sayur-hijau');
        $response->assertSee('"calories":28', false);
    }

    public function test_recipe_show_page_hides_selector_when_ingredient_has_no_group(): void
    {
        $beras = Ingredient::create(['name' => 'Beras Putih', 'unit' => 'gram']);
        $kentang = Ingredient::create(['name' => 'Kentang', 'unit' => 'gram']);

        $recipe = $this->makeRecipe([$beras->id => 50, $kentang->id => 40]);

        $this->get('/resep/'.$recipe->slug)
            ->assertOk()
            ->assertDontSee('Ganti:');
    }

    public function test_recipe_show_page_embeds_per_100g_nutrition_for_group_members(): void
    {
        $bayam = Ingredient::create([
            'name' => 'Bayam', 'unit' => 'gram',
            'calories' => 23, 'protein' => 2.9, 'fat' => 0.4,
            'carbohydrates' => 3.6, 'fiber' => 2.2, 'calcium' => 99,
            'iron' => 2.7, 'vitamin_a' => 469, 'vitamin_c' => 28.1,
            'substitution_group' => 'sayur-hijau',
        ]);
        $sawi = Ingredient::create([
            'name' => 'Sawi', 'unit' => 'gram',
            'calories' => 28, 'protein' => 2.3, 'fat' => 0.3,
            'carbohydrates' => 4.0, 'fiber' => 2.5, 'calcium' => 220,
            'iron' => 2.9, 'vitamin_a' => 0, 'vitamin_c' => 102,
            'substitution_group' => 'sayur-hijau',
        ]);

        $recipe = $this->makeRecipe([$bayam->id => 20]);

        $response = $this->get('/resep/'.$recipe->slug);

        $response->assertSee('"per100"', false);
        $response->assertSee('"protein":2.9', false);
        $response->assertSee('"calcium":220', false);
        $response->assertSee('"vitamin_c":102', false);
    }
}
