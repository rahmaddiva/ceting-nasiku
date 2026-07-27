<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\DataTableQuery;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RecipeController extends Controller
{
    use DataTableQuery;

    public function index()
    {
        return view('admin.recipes.index');
    }

    public function data(Request $request)
    {
        $query = Recipe::query()->with('category');

        return $this->dataTable(
            $request,
            $query,
            [
                0 => null,
                1 => 'image',
                2 => 'title',
                3 => 'category_id',
                4 => 'age_group',
                5 => 'servings',
                6 => 'is_published',
                7 => 'created_at',
                8 => null,
            ],
            ['title', 'age_group'],
            function (Recipe $recipe, int $no) {
                $image = $recipe->image
                    ? '<img src="'.asset($recipe->image).'" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">'
                    : '<div style="width:48px;height:48px;background:#f3f4f6;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#9ca3af;"><i class="fas fa-image"></i></div>';

                $status = $recipe->is_published
                    ? '<span class="badge badge-success">Publik</span>'
                    : '<span class="badge badge-warning">Draft</span>';

                $generateBtn = $recipe->image
                    ? ''
                    : ' <button class="btn-icon generate" title="Generate Gambar" onclick="generateSingleImage('.$recipe->id.', this)"><i class="fas fa-wand-magic-sparkles"></i></button>';

                $actions = '<div class="actions">'
                    .'<a href="'.e(route('admin.recipes.edit', $recipe)).'" class="btn-icon edit" title="Edit"><i class="fas fa-pen"></i></a>'
                    .'<form action="'.e(route('admin.recipes.destroy', $recipe)).'" method="POST" onsubmit="return confirm(\'Yakin hapus resep ini?\')" style="display:inline">'
                    .csrf_field().method_field('DELETE')
                    .'<button type="submit" class="btn-icon delete" title="Hapus"><i class="fas fa-trash"></i></button>'
                    .'</form>'
                    .$generateBtn
                    .'</div>';

                return [
                    $no,
                    $image,
                    '<strong>'.e($recipe->title).'</strong>',
                    e($recipe->category->name ?? '—'),
                    e($recipe->age_group ?? '—'),
                    e((string) $recipe->servings),
                    $status,
                    $recipe->created_at?->format('d M Y') ?? '—',
                    $actions,
                ];
            }
        );
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
        $data['slug'] = Str::slug($request->title).'-'.Str::random(5);
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
