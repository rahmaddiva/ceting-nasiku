<?php

namespace App\Services;

use App\Models\Recipe;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RecipeImageService
{
    private string $apiUrl = 'https://openagentic.id/api/v1/images/generations';

    private string $model = 'ali-z-image-turbo';

    public function generateForRecipes(?int $limit = null, ?string $model = null): array
    {
        $apiKey = env('OPENAGENTIC_API_KEY');

        if (! $apiKey) {
            return ['generated' => 0, 'remaining' => 0, 'errors' => ['API key tidak ditemukan.']];
        }

        $model = $model ?: $this->model;

        $query = Recipe::whereNull('image')->orWhere('image', '');
        $total = $query->count();

        if ($total === 0) {
            return ['generated' => 0, 'remaining' => 0, 'errors' => []];
        }

        $recipes = $limit ? $query->limit($limit)->get() : $query->get();
        $generated = 0;
        $errors = [];

        foreach ($recipes as $recipe) {
            $prompt = $this->buildPrompt($recipe);

            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer '.$apiKey,
                    'Content-Type' => 'application/json',
                ])->timeout(120)->post($this->apiUrl, [
                    'model' => $model,
                    'prompt' => $prompt,
                    'n' => 1,
                    'size' => '1024x1024',
                    'response_format' => 'b64_json',
                ]);

                if ($response->failed()) {
                    $body = $response->json();
                    $errMsg = $body['error']['message'] ?? 'Unknown error';

                    if ($response->status() === 429) {
                        Log::warning('RecipeImageService: Rate limit hit after '.$generated.' images.');
                        $errors[] = 'Rate limit tercapai setelah '.$generated.' gambar. Coba lagi nanti.';

                        break;
                    }

                    $errors[] = "Gagal generate untuk \"{$recipe->title}\": {$errMsg}";

                    continue;
                }

                $data = $response->json();
                $b64 = $data['data'][0]['b64_json'] ?? null;

                if (! $b64) {
                    $errors[] = "Response tidak valid untuk \"{$recipe->title}\".";

                    continue;
                }

                $filename = Str::random(40).'.jpg';
                $dir = public_path('images/recipes');
                if (! is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }
                file_put_contents($dir.'/'.$filename, base64_decode($b64));

                $recipe->update(['image' => 'images/recipes/'.$filename]);
                $generated++;
            } catch (\Exception $e) {
                Log::error('RecipeImageService Exception: '.$e->getMessage());
                $errors[] = "Exception untuk \"{$recipe->title}\": ".$e->getMessage();

                continue;
            }
        }

        $remaining = Recipe::whereNull('image')->orWhere('image', '')->count();

        return [
            'generated' => $generated,
            'remaining' => $remaining,
            'errors' => $errors,
        ];
    }

    private function buildPrompt(Recipe $recipe): string
    {
        $title = $recipe->title;
        $ageGroup = $recipe->age_group ?? 'anak';

        return "Professional food photography of {$title}, Indonesian {$ageGroup} meal, "
            .'warm lighting, ceramic plate, wooden table, garnished, appetizing, '
            .'top-down angle, shallow depth of field, high quality, 4k';
    }
}
