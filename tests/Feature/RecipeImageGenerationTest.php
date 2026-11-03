<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use App\Services\RecipeImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
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

    protected function tearDown(): void
    {
        File::deleteDirectory(public_path('images/recipes'));

        parent::tearDown();
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
            'bansos-ai.digitalindotech.cloud/*' => Http::response([
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

    public function test_regenerates_recipes_whose_image_file_is_missing(): void
    {
        $category = Category::create(['name' => 'MPASI', 'slug' => 'mpasi']);

        $recipe = Recipe::create([
            'user_id' => $this->admin->id,
            'category_id' => $category->id,
            'title' => 'Bubur Hati Ayam',
            'slug' => 'bubur-hati-ayam',
            'description' => 'Test',
            'instructions' => 'Test',
            'servings' => 2,
            'age_group' => '6-8 bulan',
            'image' => 'images/recipes/hilang.jpg',
            'is_published' => true,
        ]);

        $this->assertFileDoesNotExist(public_path($recipe->image));

        $goodImage = 'images/recipes/ada.jpg';
        File::ensureDirectoryExists(public_path('images/recipes'));
        File::put(public_path($goodImage), 'gambar-ada');

        Recipe::create([
            'user_id' => $this->admin->id,
            'category_id' => $category->id,
            'title' => 'Tim Ikan Kembung',
            'slug' => 'tim-ikan-kembung',
            'description' => 'Test',
            'instructions' => 'Test',
            'servings' => 2,
            'age_group' => '9-11 bulan',
            'image' => $goodImage,
            'is_published' => true,
        ]);

        $table = $this->actingAs($this->admin)->getJson('/admin/recipes/data');
        $table->assertOk();
        $this->assertSame(
            1,
            substr_count($table->getContent(), 'generateSingleImage'),
            'Tombol generate hanya boleh muncul pada resep yang gambarnya hilang.'
        );

        Http::fake([
            'bansos-ai.digitalindotech.cloud/*' => Http::response([
                'data' => [['b64_json' => base64_encode('image-baru')]],
            ], 200),
        ]);

        $this->actingAs($this->admin)
            ->postJson('/admin/recipes/generate-images')
            ->assertOk()
            ->assertJson(['success' => true, 'generated' => 1, 'remaining' => 0]);

        $recipe->refresh();

        $this->assertNotSame('images/recipes/hilang.jpg', $recipe->image);
        $this->assertFileExists(public_path($recipe->image));
    }

    public function test_single_generation_replaces_stale_file_and_uses_payload_extension(): void
    {
        $category = Category::create(['name' => 'MPASI', 'slug' => 'mpasi']);

        $oldImage = 'images/recipes/lama.jpg';
        File::ensureDirectoryExists(public_path('images/recipes'));
        File::put(public_path($oldImage), 'gambar-lama');

        $recipe = Recipe::create([
            'user_id' => $this->admin->id,
            'category_id' => $category->id,
            'title' => 'Sup Ikan Tuna',
            'slug' => 'sup-ikan-tuna',
            'description' => 'Test',
            'instructions' => 'Test',
            'servings' => 2,
            'age_group' => '6-8 bulan',
            'image' => $oldImage,
            'is_published' => true,
        ]);

        $gif = 'R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';

        Http::fake([
            'bansos-ai.digitalindotech.cloud/*' => Http::response([
                'data' => [['b64_json' => $gif]],
            ], 200),
        ]);

        $this->actingAs($this->admin)
            ->postJson('/admin/recipes/generate-single-image', ['id' => $recipe->id])
            ->assertOk()
            ->assertJson(['success' => true]);

        $recipe->refresh();

        $this->assertStringEndsWith('.gif', $recipe->image);
        $this->assertFileExists(public_path($recipe->image));
        $this->assertFileDoesNotExist(public_path($oldImage));
    }

    public function test_writes_images_into_configured_directory(): void
    {
        $dir = storage_path('framework/testing/recipe-images');
        File::deleteDirectory($dir);
        config(['services.openagentic.image_dir' => $dir]);

        $category = Category::create(['name' => 'MPASI', 'slug' => 'mpasi']);

        $recipe = Recipe::create([
            'user_id' => $this->admin->id,
            'category_id' => $category->id,
            'title' => 'Bubur Beras Merah',
            'slug' => 'bubur-beras-merah',
            'description' => 'Test',
            'instructions' => 'Test',
            'servings' => 2,
            'age_group' => '6-8 bulan',
            'is_published' => true,
        ]);

        Http::fake([
            'bansos-ai.digitalindotech.cloud/*' => Http::response([
                'data' => [['b64_json' => 'R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==']],
            ], 200),
        ]);

        $this->actingAs($this->admin)
            ->postJson('/admin/recipes/generate-single-image', ['id' => $recipe->id])
            ->assertOk()
            ->assertJson(['success' => true]);

        $recipe->refresh();
        $file = $dir.'/'.basename($recipe->image);

        $this->assertStringStartsWith('images/recipes/', $recipe->image, 'Path di DB harus tetap relatif.');
        $this->assertFileExists($file);
        $this->assertFileDoesNotExist(public_path($recipe->image));

        RecipeImageService::deleteFile($recipe->image);
        $this->assertFileDoesNotExist($file);

        File::deleteDirectory($dir);
    }

    public function test_rejects_model_without_image_route(): void
    {
        $category = Category::create(['name' => 'MPASI', 'slug' => 'mpasi']);

        $recipe = Recipe::create([
            'user_id' => $this->admin->id,
            'category_id' => $category->id,
            'title' => 'Puree Wortel',
            'slug' => 'puree-wortel',
            'description' => 'Test',
            'instructions' => 'Test',
            'servings' => 1,
            'age_group' => '6-8 bulan',
            'is_published' => true,
        ]);

        Http::fake();

        $this->actingAs($this->admin)
            ->postJson('/admin/recipes/generate-single-image', ['id' => $recipe->id, 'model' => 'ali-z-image-turbo'])
            ->assertStatus(422)
            ->assertJsonValidationErrors('model');

        Http::assertNothingSent();
    }
}
