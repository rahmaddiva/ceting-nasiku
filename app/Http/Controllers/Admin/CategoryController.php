<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\DataTableQuery;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use DataTableQuery;

    public function index()
    {
        return view('admin.categories.index');
    }

    public function data(Request $request)
    {
        $query = Category::query()->withCount('recipes');

        return $this->dataTable(
            $request,
            $query,
            [
                0 => null,
                1 => 'name',
                2 => 'description',
                3 => 'recipes_count',
                4 => null,
            ],
            ['name', 'description'],
            function (Category $cat, int $no) {
                $actions = '<div class="actions">'
                    . '<a href="' . e(route('admin.categories.edit', $cat)) . '" class="btn-icon edit" title="Edit"><i class="fas fa-pen"></i></a>'
                    . '<form action="' . e(route('admin.categories.destroy', $cat)) . '" method="POST" onsubmit="return confirm(\'Yakin hapus kategori ini?\')" style="display:inline">'
                    . csrf_field() . method_field('DELETE')
                    . '<button type="submit" class="btn-icon delete" title="Hapus"><i class="fas fa-trash"></i></button>'
                    . '</form></div>';

                return [
                    $no,
                    '<strong>' . e($cat->name) . '</strong>',
                    e(Str::limit($cat->description ?? '', 60)),
                    '<span class="badge badge-success">' . e((string) $cat->recipes_count) . '</span>',
                    $actions,
                ];
            }
        );
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'description']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect('/admin/categories')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'description']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect('/admin/categories')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('/admin/categories')->with('success', 'Kategori berhasil dihapus!');
    }
}
