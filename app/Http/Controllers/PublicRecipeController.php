<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;

class PublicRecipeController extends Controller
{
    public function index(Request $request)
    {
        $query = Recipe::published()->with(['category', 'ingredients']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('age_group')) {
            $query->where('age_group', $request->age_group);
        }

        $recipes = $query->latest()->paginate(9);
        $categories = Category::all();

        return view('recipes.index', compact('recipes', 'categories'));
    }

    public function show($slug)
    {
        $recipe = Recipe::where('slug', $slug)
            ->published()
            ->with(['category', 'ingredients', 'user'])
            ->firstOrFail();

        $related = Recipe::published()
            ->where('category_id', $recipe->category_id)
            ->where('id', '!=', $recipe->id)
            ->take(3)
            ->get();

        $substitutionGroups = Ingredient::whereNotNull('substitution_group')
            ->get()
            ->groupBy('substitution_group')
            ->map(fn ($group) => $group->map(fn (Ingredient $ing) => [
                'id' => $ing->id,
                'name' => $ing->name,
                'unit' => $ing->unit,
                'per100' => [
                    'calories' => $ing->calories,
                    'protein' => $ing->protein,
                    'fat' => $ing->fat,
                    'carbohydrates' => $ing->carbohydrates,
                    'fiber' => $ing->fiber,
                    'calcium' => $ing->calcium,
                    'iron' => $ing->iron,
                    'vitamin_a' => $ing->vitamin_a,
                    'vitamin_c' => $ing->vitamin_c,
                ],
            ])->values());

        return view('recipes.show', compact('recipe', 'related', 'substitutionGroups'));
    }
}
