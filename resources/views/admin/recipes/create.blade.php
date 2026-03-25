@extends('admin.layouts.app')
@section('title', 'Tambah Resep')

@section('content')
<div class="admin-header">
    <h1><i class="fas fa-plus-circle" style="color: var(--primary-600);"></i> Tambah Resep Baru</h1>
    <a href="/admin/recipes" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div style="background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 2rem;">
    @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    <form action="/admin/recipes" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="title">Judul Resep *</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="form-group">
                <label for="category_id">Kategori *</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi *</label>
            <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="instructions">Langkah-Langkah Pembuatan *</label>
            <textarea name="instructions" id="instructions" class="form-control" rows="6" placeholder="Tulis setiap langkah pada baris baru..." required>{{ old('instructions') }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="servings">Jumlah Porsi *</label>
                <input type="number" name="servings" id="servings" class="form-control" value="{{ old('servings', 1) }}" min="1" required>
            </div>
            <div class="form-group">
                <label for="age_group">Kelompok Usia</label>
                <select name="age_group" id="age_group" class="form-control">
                    <option value="">-- Pilih --</option>
                    <option value="6-8 bulan" {{ old('age_group') == '6-8 bulan' ? 'selected' : '' }}>6-8 bulan</option>
                    <option value="9-11 bulan" {{ old('age_group') == '9-11 bulan' ? 'selected' : '' }}>9-11 bulan</option>
                    <option value="1-3 tahun" {{ old('age_group') == '1-3 tahun' ? 'selected' : '' }}>1-3 tahun</option>
                    <option value="4-6 tahun" {{ old('age_group') == '4-6 tahun' ? 'selected' : '' }}>4-6 tahun</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Gambar Resep</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>
        </div>

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                <label for="is_published">Publikasikan resep ini</label>
            </div>
        </div>

        <!-- Ingredients Section -->
        <div style="margin-top: 2rem; padding-top: 2rem; border-top: 2px solid var(--gray-100);">
            <h3 style="margin-bottom: 1rem;"><i class="fas fa-carrot" style="color: var(--accent-500);"></i> Bahan-Bahan</h3>
            <div id="ingredients-container">
                <div class="ingredient-row">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Bahan *</label>
                        <select name="ingredients[0][id]" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach($ingredients as $ing)
                                <option value="{{ $ing->id }}">{{ $ing->name }} (per 100{{ $ing->unit }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Jumlah (gram) *</label>
                        <input type="number" name="ingredients[0][quantity]" class="form-control" min="0.1" step="0.1" required>
                    </div>
                    <button type="button" class="btn-remove" onclick="removeIngredient(this)"><i class="fas fa-times"></i></button>
                </div>
            </div>
            <button type="button" class="btn btn-outline btn-sm" onclick="addIngredient()" style="margin-top: 1rem;">
                <i class="fas fa-plus"></i> Tambah Bahan
            </button>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Resep</button>
            <a href="/admin/recipes" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    let ingredientIndex = 1;
    function addIngredient() {
        const container = document.getElementById('ingredients-container');
        const html = `
            <div class="ingredient-row">
                <div class="form-group" style="margin-bottom: 0;">
                    <label>Bahan *</label>
                    <select name="ingredients[${ingredientIndex}][id]" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        @foreach($ingredients as $ing)
                            <option value="{{ $ing->id }}">{{ $ing->name }} (per 100{{ $ing->unit }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label>Jumlah (gram) *</label>
                    <input type="number" name="ingredients[${ingredientIndex}][quantity]" class="form-control" min="0.1" step="0.1" required>
                </div>
                <button type="button" class="btn-remove" onclick="removeIngredient(this)"><i class="fas fa-times"></i></button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        ingredientIndex++;
    }

    function removeIngredient(btn) {
        const rows = document.querySelectorAll('#ingredients-container .ingredient-row');
        if (rows.length > 1) {
            btn.closest('.ingredient-row').remove();
        }
    }
</script>
@endpush
