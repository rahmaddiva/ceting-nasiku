@extends('layouts.public')
@section('body_class', 'page-inner')
@section('title', 'Koleksi Resep — CETING NASIKU')
@section('meta_description', 'Temukan koleksi resep makanan bergizi seimbang untuk bayi, balita, ibu hamil, dan ibu menyusui. Resep MPASI dan makanan pencegah stunting.')
@section('og_title', 'Koleksi Resep — CETING NASIKU')
@section('og_description', 'Temukan koleksi resep makanan bergizi seimbang untuk bayi, balita, ibu hamil, dan ibu menyusui.')
@section('og_type', 'website')

@section('content')
<section style="padding-top: 6rem;">
    <div class="container" style="padding-top: 2rem;">
        <div class="section-header">
            <div class="section-badge"><i class="fas fa-book-open"></i> Koleksi Resep</div>
            <h2>Resep <span>Bergizi Seimbang</span></h2>
            <p>Temukan resep yang tepat untuk kebutuhan nutrisi anak Anda</p>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <form action="/resep" method="GET" style="display: flex; gap: 1rem; flex: 1; flex-wrap: wrap;">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari resep...">
                </div>
                <select name="category" class="form-control" style="width: auto; min-width: 180px;" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
            </form>
        </div>

        <!-- Recipes Grid -->
        @if($recipes->count() > 0)
        <div class="recipes-grid">
            @foreach($recipes as $recipe)
            <div class="recipe-card">
                <div class="recipe-card-image">
                    @if($recipe->image)
                        <img src="{{ asset($recipe->image) }}" alt="{{ $recipe->title }}">
                    @else
                        <i class="fas fa-utensils"></i>
                    @endif
                    <span class="recipe-card-badge">{{ $recipe->category->name ?? 'Umum' }}</span>
                </div>
                <div class="recipe-card-body">
                    <h3><a href="/resep/{{ $recipe->slug }}">{{ $recipe->title }}</a></h3>
                    <p>{{ $recipe->description }}</p>
                    <div class="recipe-card-meta">
                        <span><i class="fas fa-fire-flame-curved"></i> {{ $recipe->per_serving_nutrition['calories'] ?? 0 }} kkal</span>
                        <span><i class="fas fa-dna"></i> {{ $recipe->per_serving_nutrition['protein'] ?? 0 }}g protein</span>
                        <span><i class="fas fa-users"></i> {{ $recipe->servings }} porsi</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $recipes->withQueryString()->links('pagination.ceting') }}
        </div>
        @else
        <div style="text-align: center; padding: 4rem 0;">
            <i class="fas fa-search" style="font-size: 3rem; color: var(--gray-300); margin-bottom: 1rem; display: block;"></i>
            <h3 style="color: var(--gray-500);">Resep tidak ditemukan</h3>
            <p style="color: var(--text-muted);">Coba ubah kata kunci pencarian atau filter kategori.</p>
        </div>
        @endif
    </div>
</section>
@endsection
