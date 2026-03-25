<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::orderBy('name')->get();
        return view('admin.ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        return view('admin.ingredients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:20',
            'calories' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'carbohydrates' => 'required|numeric|min:0',
            'fiber' => 'nullable|numeric|min:0',
            'calcium' => 'nullable|numeric|min:0',
            'iron' => 'nullable|numeric|min:0',
            'vitamin_a' => 'nullable|numeric|min:0',
            'vitamin_c' => 'nullable|numeric|min:0',
        ]);

        Ingredient::create($request->all());

        return redirect('/admin/ingredients')->with('success', 'Bahan makanan berhasil ditambahkan!');
    }

    public function edit(Ingredient $ingredient)
    {
        return view('admin.ingredients.edit', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:20',
            'calories' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'carbohydrates' => 'required|numeric|min:0',
            'fiber' => 'nullable|numeric|min:0',
            'calcium' => 'nullable|numeric|min:0',
            'iron' => 'nullable|numeric|min:0',
            'vitamin_a' => 'nullable|numeric|min:0',
            'vitamin_c' => 'nullable|numeric|min:0',
        ]);

        $ingredient->update($request->all());

        return redirect('/admin/ingredients')->with('success', 'Bahan makanan berhasil diperbarui!');
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect('/admin/ingredients')->with('success', 'Bahan makanan berhasil dihapus!');
    }
}
