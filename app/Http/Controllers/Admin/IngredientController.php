<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\DataTableQuery;
use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    use DataTableQuery;

    public function index()
    {
        return view('admin.ingredients.index');
    }

    public function data(Request $request)
    {
        $query = Ingredient::query();

        return $this->dataTable(
            $request,
            $query,
            [
                0 => null,
                1 => 'name',
                2 => 'unit',
                3 => 'calories',
                4 => 'protein',
                5 => 'fat',
                6 => 'carbohydrates',
                7 => 'calcium',
                8 => 'iron',
                9 => null,
            ],
            ['name', 'unit'],
            function (Ingredient $ing, int $no) {
                $actions = '<div class="actions">'
                    .'<a href="'.e(route('admin.ingredients.edit', $ing)).'" class="btn-icon edit" title="Edit"><i class="fas fa-pen"></i></a>'
                    .'<form action="'.e(route('admin.ingredients.destroy', $ing)).'" method="POST" onsubmit="return confirm(\'Yakin hapus bahan ini?\')" style="display:inline">'
                    .csrf_field().method_field('DELETE')
                    .'<button type="submit" class="btn-icon delete" title="Hapus"><i class="fas fa-trash"></i></button>'
                    .'</form></div>';

                return [
                    $no,
                    '<strong>'.e($ing->name).'</strong>',
                    '<small style="color: var(--text-muted)">'.e($ing->unit).'</small>',
                    e(number_format((float) $ing->calories, 1)).' kkal',
                    e(number_format((float) $ing->protein, 1)).' g',
                    e(number_format((float) $ing->fat, 1)).' g',
                    e(number_format((float) $ing->carbohydrates, 1)).' g',
                    e(number_format((float) $ing->calcium, 1)).' mg',
                    e(number_format((float) $ing->iron, 1)).' mg',
                    $actions,
                ];
            }
        );
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
