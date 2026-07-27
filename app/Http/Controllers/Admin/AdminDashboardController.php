<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_recipes' => Recipe::count(),
            'total_ingredients' => Ingredient::count(),
            'total_categories' => Category::count(),
            'total_users' => User::where('role', 'user')->count(),
            'published_recipes' => Recipe::where('is_published', true)->count(),
            'recipes_without_image' => Recipe::whereNull('image')->orWhere('image', '')->count(),
            'recipes_with_image' => Recipe::whereNotNull('image')->where('image', '!=', '')->count(),
        ];

        $latest_recipes = Recipe::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latest_recipes'));
    }
}
