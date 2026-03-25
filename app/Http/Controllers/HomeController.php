<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Recipe;

class HomeController extends Controller
{
    public function index()
    {
        $featured_recipes = Recipe::published()
            ->with(['category', 'ingredients'])
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::withCount('recipes')->get();

        $stats = [
            'total_recipes' => Recipe::published()->count(),
            'total_categories' => Category::count(),
            'total_ingredients' => \App\Models\Ingredient::count(),
        ];

        return view('home', compact('featured_recipes', 'categories', 'stats'));
    }
}
