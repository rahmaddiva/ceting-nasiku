@extends('layouts.public')
@section('body_class', 'page-inner')
@section('title', 'Tambah Anak — CETING NASIKU')

@section('content')
<div style="padding-top: 6rem;">
    <div class="container" style="max-width: 640px;">
        <a href="{{ route('profil.index') }}" style="color: var(--text-muted); font-size: 0.9rem;"><i class="fas fa-arrow-left"></i> Kembali</a>
        <h1 style="color: var(--primary-900); margin: 0.75rem 0 0.25rem;">Tambah Data Anak</h1>
        <p style="color: var(--text-muted);">Data ini dipakai untuk menghitung status gizi sesuai standar WHO.</p>

        @if($errors->any())
        <div class="alert alert-error" style="margin-top: 1rem;">
            <i class="fas fa-exclamation-circle"></i>
            <div>@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
        </div>
        @endif

        <div style="background: #fff; border: 1px solid var(--primary-100); border-radius: 16px; padding: 2rem; margin-top: 1.25rem; box-shadow: 0 2px 12px rgba(8,145,178,.07);">
            <form action="{{ route('profil.children.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Nama Anak *</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Nama lengkap anak" required autofocus>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-venus-mars"></i> Jenis Kelamin *</label>
                    <div style="display: flex; gap: 1rem; margin-top: 0.35rem;">
                        <label class="form-check" style="display: flex; align-items: center; gap: 0.5rem; font-weight: 500;">
                            <input type="radio" name="gender" value="male" {{ old('gender', 'male') === 'male' ? 'checked' : '' }} required> Laki-laki
                        </label>
                        <label class="form-check" style="display: flex; align-items: center; gap: 0.5rem; font-weight: 500;">
                            <input type="radio" name="gender" value="female" {{ old('gender') === 'female' ? 'checked' : '' }}> Perempuan
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="birth_date"><i class="fas fa-cake-candles"></i> Tanggal Lahir *</label>
                    <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ old('birth_date') }}" max="{{ date('Y-m-d') }}" required>
                </div>
                <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    <a href="{{ route('profil.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
