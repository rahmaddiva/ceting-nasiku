@extends('admin.layouts.app')
@section('title', isset($ingredient) ? 'Edit Bahan' : 'Tambah Bahan')

@section('content')
<div class="admin-header">
    <h1><i class="fas fa-{{ isset($ingredient) ? 'pen' : 'plus-circle' }}" style="color: var(--primary-600);"></i> {{ isset($ingredient) ? 'Edit' : 'Tambah' }} Bahan Makanan</h1>
    <a href="/admin/ingredients" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div style="background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 2rem;">
    @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
        </div>
    @endif

    <form action="{{ isset($ingredient) ? '/admin/ingredients/'.$ingredient->id : '/admin/ingredients' }}" method="POST">
        @csrf
        @if(isset($ingredient)) @method('PUT') @endif

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="name">Nama Bahan *</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $ingredient->name ?? '') }}" required>
            </div>
            <div class="form-group">
                <label for="unit">Satuan *</label>
                <select name="unit" id="unit" class="form-control" required>
                    @php $u = old('unit', $ingredient->unit ?? 'gram'); @endphp
                    <option value="gram" {{ $u == 'gram' ? 'selected' : '' }}>gram</option>
                    <option value="ml" {{ $u == 'ml' ? 'selected' : '' }}>ml</option>
                </select>
            </div>

        <div class="form-group" style="grid-column: 1 / -1; margin-top: 0.5rem; max-width: 480px;">
            <label for="substitution_group">Grup Substitusi</label>
            <input type="text" name="substitution_group" id="substitution_group" class="form-control" value="{{ old('substitution_group', $ingredient->substitution_group ?? '') }}" list="substitution-group-list" placeholder="cth: sayur-hijau">
            <datalist id="substitution-group-list">
                @foreach($groups ?? [] as $groupName)
                <option value="{{ $groupName }}"></option>
                @endforeach
            </datalist>
            <small style="color: var(--text-muted);">Bahan dalam grup sama bisa saling mengganti di halaman resep (mis. <code>sayur-hijau</code>: bayam, sawi, daun kelor). Kosongkan jika tidak bisa diganti.</small>
        </div>
        </div>

        <h4 style="margin: 1.5rem 0 1rem; color: var(--gray-700);">Kandungan Gizi (per 100g/ml)</h4>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
            @php
                $fields = [
                    'calories' => ['Kalori', 'kkal'],
                    'protein' => ['Protein', 'g'],
                    'fat' => ['Lemak', 'g'],
                    'carbohydrates' => ['Karbohidrat', 'g'],
                    'fiber' => ['Serat', 'g'],
                    'calcium' => ['Kalsium', 'mg'],
                    'iron' => ['Zat Besi', 'mg'],
                    'vitamin_a' => ['Vitamin A', 'mcg'],
                    'vitamin_c' => ['Vitamin C', 'mg'],
                ];
            @endphp

            @foreach($fields as $field => [$label, $unit])
            <div class="form-group">
                <label for="{{ $field }}">{{ $label }} ({{ $unit }})</label>
                <input type="number" name="{{ $field }}" id="{{ $field }}" class="form-control" value="{{ old($field, $ingredient->$field ?? 0) }}" min="0" step="0.01">
            </div>
            @endforeach
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ isset($ingredient) ? 'Update' : 'Simpan' }}</button>
            <a href="/admin/ingredients" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
