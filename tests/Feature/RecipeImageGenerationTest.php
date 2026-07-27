<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RecipeImageGenerationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_generate_recipe_images(): void
    {
        $category = Category::create(['name' => 'MPASI 6-8 Bulan', 'slug' => 'mpasi-6-8']);

        $recipe1 = Recipe::create([
            'user_id' => $this->admin->id,
            'category_id' => $category->id,
            'title' => 'Bubur Ayam Wortel',
            'slug' => 'bubur-ayam-wortel',
            'description' => 'Test',
            'instructions' => 'Test',
            'servings' => 2,
            'age_group' => '6-8 bulan',
            'is_published' => true,
        ]);

        $recipe2 = Recipe::create([
            'user_id' => $this->admin->id,
            'category_id' => $category->id,
            'title' => 'Sup Ikan Tuna',
            'slug' => 'sup-ikan-tuna',
            'description' => 'Test',
            'instructions' => 'Test',
            'servings' => 2,
            'age_group' => '6-8 bulan',
            'is_published' => true,
        ]);

        $fakeImage = base64_encode('fake-image-data');

        Http::fake([
            'openagentic.id/*' => Http::response([
                'data' => [['b64_json' => $fakeImage]],
            ], 200),
        ]);

        $response = $this->actingAs($this->admin)
            ->postJson('/admin/recipes/generate-images');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'generated' => 2,
                'remaining' => 0,
            ]);

        $recipe1->refresh();
        $recipe2->refresh();

        $this->assertNotNull($recipe1->image);
        $this->assertNotNull($recipe2->image);
        $this->assertStringStartsWith('images/recipes/', $recipe1->image);
        $this->assertStringStartsWith('images/recipes/', $recipe2->image);
        $this->assertFileExists(public_path($recipe1->image));
        $this->assertFileExists(public_path($recipe2->image));
    }

    public function test_returns_success_when_no_recipes_need_images(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson('/admin/recipes/generate-images');

        $response->assertOk()
            ->assertJson([
                'success' => false,
                'generated' => 0,
                'remaining' => 0,
            ]);
    }

    public function test_handles_api_rate_limit_gracefully(): void
    {
        $category = Category::create(['name' => 'MPASI', 'slug' => 'mpasi']);

        Recipe::create([
            'user_id' => $this->admin->id,
            'category_id' => $category->id,
            'title' => 'Resep 1',
            'slug' => 'resep-1',
            'description' => 'Test',
            'instructions' => 'Test',
            'servings' => 2,
            'age_group' => '6-8 bulan',
            'is_published' => true,
        ]);

        Recipe::create([
            'user_id' => $this->admin->id,
            'category_id' => $category->id,
            'title' => 'Resep 2',
            'slug' => 'resep-2',
            'description' => 'Test',
            'instructions' => 'Test',
            'servings' => 2,
            'age_group' => '6-8 bulan',
            'is_published' => true,
        ]);

        $callCount = 0;
        Http::fake(function ($request) use (&$callCount) {
            $callCount++;

            if ($callCount === 1) {
                return Http::response([
                    'data' => [['b64_json' => base64_encode('image-1')]],
                ], 200);
            }

            return Http::response([
                'error' => ['message' => 'Rate limit exceeded'],
            ], 429);
        });

        $response = $this->actingAs($this->admin)
            ->postJson('/admin/recipes/generate-images');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'generated' => 1,
            ])
            ->assertJsonFragment(['remaining' => 1]);
    }
}
