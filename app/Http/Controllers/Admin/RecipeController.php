<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with(['category'])->latest()->get();
        return view('admin.recipes.index', compact('recipes'));
    }

    public function create()
    {
        $categories = Category::all();
        $ingredients = Ingredient::orderBy('name')->get();
        return view('admin.recipes.create', compact('categories', 'ingredients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'servings' => 'required|integer|min:1',
            'age_group' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0.1',
        ]);

        $data = $request->only(['title', 'category_id', 'description', 'instructions', 'servings', 'age_group']);
        $data['slug'] = Str::slug($request->title) . '-' . Str::random(5);
        $data['user_id'] = auth()->id();
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('recipes', 'public');
        }

        $recipe = Recipe::create($data);

        // Attach ingredients
        foreach ($request->ingredients as $ing) {
            $recipe->ingredients()->attach($ing['id'], ['quantity_grams' => $ing['quantity']]);
        }

        return redirect('/admin/recipes')->with('success', 'Resep berhasil ditambahkan!');
    }

    public function edit(Recipe $recipe)
    {
        $categories = Category::all();
        $ingredients = Ingredient::orderBy('name')->get();
        $recipe->load('ingredients');
        return view('admin.recipes.edit', compact('recipe', 'categories', 'ingredients'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'servings' => 'required|integer|min:1',
            'age_group' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0.1',
        ]);

        $data = $request->only(['title', 'category_id', 'description', 'instructions', 'servings', 'age_group']);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('recipes', 'public');
        }

        $recipe->update($data);

        // Sync ingredients
        $syncData = [];
        foreach ($request->ingredients as $ing) {
            $syncData[$ing['id']] = ['quantity_grams' => $ing['quantity']];
        }
        $recipe->ingredients()->sync($syncData);

        return redirect('/admin/recipes')->with('success', 'Resep berhasil diperbarui!');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->ingredients()->detach();
        $recipe->delete();

        return redirect('/admin/recipes')->with('success', 'Resep berhasil dihapus!');
    }
}
