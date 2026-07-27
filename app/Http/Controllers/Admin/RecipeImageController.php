<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RecipeImageService;
use Illuminate\Http\JsonResponse;

class RecipeImageController extends Controller
{
    public function generate(RecipeImageService $service): JsonResponse
    {
        $result = $service->generateForRecipes();

        return response()->json([
            'success' => $result['generated'] > 0,
            'generated' => $result['generated'],
            'remaining' => $result['remaining'],
            'errors' => $result['errors'],
        ]);
    }
}
