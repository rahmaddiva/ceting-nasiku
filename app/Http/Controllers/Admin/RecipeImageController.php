<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Services\RecipeImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecipeImageController extends Controller
{
    public function generate(Request $request, RecipeImageService $service): JsonResponse
    {
        $request->validate([
            'model' => 'nullable|string',
        ]);

        $result = $service->generateForRecipes(null, $request->input('model'));

        return response()->json([
            'success' => $result['generated'] > 0,
            'generated' => $result['generated'],
            'remaining' => $result['remaining'],
            'errors' => $result['errors'],
        ]);
    }

    public function generateSingle(Request $request, RecipeImageService $service): JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:recipes,id',
            'model' => 'nullable|string',
        ]);

        $recipe = Recipe::findOrFail($request->input('id'));
        $result = $service->generateForRecipe($recipe, $request->input('model'));

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'image' => asset($result['image']),
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => $result['error'],
        ], 500);
    }
}
