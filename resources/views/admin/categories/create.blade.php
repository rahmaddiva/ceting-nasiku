@extends('admin.layouts.app')
@section('title', isset($category) ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
<div class="admin-header">
    <h1><i class="fas fa-{{ isset($category) ? 'pen' : 'plus-circle' }}" style="color: var(--primary-600);"></i> {{ isset($category) ? 'Edit' : 'Tambah' }} Kategori</h1>
    <a href="/admin/categories" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div style="background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 2rem; max-width: 600px;">
    @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
        </div>
    @endif

    <form action="{{ isset($category) ? '/admin/categories/'.$category->id : '/admin/categories' }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($category)) @method('PUT') @endif

        <div class="form-group">
            <label for="name">Nama Kategori *</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Gambar Kategori</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ isset($category) ? 'Update' : 'Simpan' }}</button>
            <a href="/admin/categories" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
