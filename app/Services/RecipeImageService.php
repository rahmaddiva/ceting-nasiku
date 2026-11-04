<?php

namespace App\Services;

use App\Models\Recipe;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RecipeImageService
{
    private function apiUrl(): string
    {
        return rtrim(config('services.openagentic.base_url', 'https://bansos-ai.digitalindotech.cloud/v1'), '/').'/images/generations';
    }

    private function defaultModel(): string
    {
        return config('services.openagentic.model', 'antigravity/gemini-3.1-flash-image');
    }

    public function generateForRecipes(?int $limit = null, ?string $model = null): array
    {
        if (! config('services.openagentic.key')) {
            return ['generated' => 0, 'remaining' => 0, 'errors' => ['API key tidak ditemukan.']];
        }

        $recipes = $this->recipesNeedingImage();

        if ($limit) {
            $recipes = $recipes->take($limit);
        }

        if ($recipes->isEmpty()) {
            return ['generated' => 0, 'remaining' => 0, 'errors' => []];
        }

        $generated = 0;
        $errors = [];

        foreach ($recipes as $recipe) {
            $result = $this->generateForRecipe($recipe, $model);

            if ($result['success']) {
                $generated++;

                continue;
            }

            $errors[] = "Gagal generate untuk \"{$recipe->title}\": {$result['error']}";

            if (! empty($result['rate_limited'])) {
                $errors[] = "Rate limit tercapai setelah {$generated} gambar. Coba lagi nanti.";

                break;
            }
        }

        return [
            'generated' => $generated,
            'remaining' => $this->remainingImages(),
            'errors' => $errors,
        ];
    }

    /**
     * Resep yang belum punya gambar, atau path gambarnya sudah tidak ada di disk.
     */
    public function recipesNeedingImage()
    {
        return Recipe::orderBy('id')->get()
            ->filter(fn (Recipe $recipe) => $this->needsImage($recipe))
            ->values();
    }

    public function remainingImages(): int
    {
        return $this->recipesNeedingImage()->count();
    }

    /**
     * Direktori file gambar. Di produksi docroot bukan public/ aplikasi,
     * jadi jalurnya bisa diarahkan lewat OPENAGENTIC_IMAGE_DIR.
     */
    public static function imageDir(): string
    {
        $dir = config('services.openagentic.image_dir');

        return $dir ? rtrim($dir, '/\\') : public_path('images/recipes');
    }

    public static function imagePath(?string $path): ?string
    {
        return $path ? self::imageDir().'/'.basename($path) : null;
    }

    private function needsImage(Recipe $recipe): bool
    {
        return ! $recipe->image || ! is_file(self::imagePath($recipe->image));
    }

    public static function deleteFile(?string $path): void
    {
        if (! $path || ! str_starts_with($path, 'images/recipes/')) {
            return;
        }

        $file = self::imagePath($path);

        if ($file && is_file($file)) {
            @unlink($file);
        }
    }

    private function buildPrompt(Recipe $recipe): string
    {
        $title = $recipe->title;
        $ageGroup = $recipe->age_group ?? 'anak';

        return "Professional food photography of {$title}, Indonesian {$ageGroup} meal, "
            .'warm lighting, ceramic plate, wooden table, garnished, appetizing, '
            .'top-down angle, shallow depth of field, high quality, 4k';
    }

    public function generateForRecipe(Recipe $recipe, ?string $model = null): array
    {
        $apiKey = config('services.openagentic.key');

        if (! $apiKey) {
            return ['success' => false, 'error' => 'API key tidak ditemukan.'];
        }

        $model = $model ?: $this->defaultModel();

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(120)->post($this->apiUrl(), [
                'model' => $model,
                'prompt' => $this->buildPrompt($recipe),
                'n' => 1,
                'size' => '1024x1024',
                'response_format' => 'b64_json',
            ]);

            if ($response->failed()) {
                $body = $response->json();

                return [
                    'success' => false,
                    'error' => $body['error']['message'] ?? 'Unknown error',
                    'rate_limited' => $response->status() === 429,
                ];
            }

            $b64 = $response->json('data.0.b64_json');

            if (! $b64) {
                return ['success' => false, 'error' => 'Response tidak valid.'];
            }

            $binary = base64_decode($b64, true);

            if ($binary === false || $binary === '') {
                return ['success' => false, 'error' => 'Data gambar tidak valid.'];
            }

            $dir = self::imageDir();

            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $filename = Str::random(40).'.'.$this->extensionFor($binary);
            file_put_contents($dir.'/'.$filename, $binary);

            $oldImage = $recipe->image;
            $imagePath = 'images/recipes/'.$filename;
            $recipe->update(['image' => $imagePath]);

            if ($oldImage && $oldImage !== $imagePath) {
                self::deleteFile($oldImage);
            }

            return ['success' => true, 'image' => $imagePath];
        } catch (\Exception $e) {
            Log::error('RecipeImageService Exception: '.$e->getMessage());

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Ekstensi mengikuti isi file yang benar-benar dikirim provider.
     */
    private function extensionFor(string $binary): string
    {
        $type = @exif_imagetype('data://application/octet-stream;base64,'.base64_encode($binary));

        return $type ? substr((string) image_type_to_extension($type, false), 0, 4) : 'jpg';
    }
}
