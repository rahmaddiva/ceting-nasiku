@extends('layouts.public')
@section('title', 'CETING NASIKU — Panduan Resep Gizi Seimbang Anti Stunting')
@section('meta_description', 'CETING NASIKU menyediakan resep makanan bergizi seimbang untuk mencegah stunting. Temukan resep MPASI, balita, dan kalkulator gizi.')

@section('content')
<!-- Hero Section with Real Photo -->
<section class="hero hero-photo">
    <div class="hero-bg-image">
        <img src="{{ asset('images/hero-mother-feeding.png') }}" alt="Ibu memberi makan anak dengan gizi seimbang">
        <div class="hero-overlay"></div>
    </div>
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <div class="section-badge section-badge-hero">
                    Panduan Gizi #1 Indonesia
                </div>
                <h1>Ciptakan <span>Generasi Sehat</span> Bebas Stunting</h1>
                <p>Temukan koleksi resep makanan bergizi seimbang yang dirancang khusus untuk memenuhi kebutuhan nutrisi anak. Cegah stunting dengan panduan porsi yang tepat dan bahan makanan bernutrisi tinggi.</p>
                <div class="hero-buttons">
                    <a href="/resep" class="btn btn-white btn-lg">
                        Lihat Resep
                    </a>
                    <a href="/kalkulator" class="btn btn-accent btn-lg">
                        Kalkulator Gizi
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-number">{{ $stats['total_recipes'] }}+</div>
                        <div class="hero-stat-label">Resep Sehat</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">{{ $stats['total_ingredients'] }}+</div>
                        <div class="hero-stat-label">Bahan Bergizi</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">{{ $stats['total_categories'] }}</div>
                        <div class="hero-stat-label">Kategori Usia</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Photo Gallery Strip -->
<section class="photo-strip">
    <div class="container">
        <div class="photo-strip-grid">
            <div class="photo-strip-item">
                <img src="{{ asset('images/baby-eating.png') }}" alt="Bayi makan MPASI bergizi">
                <div class="photo-strip-caption">
                    MPASI Bergizi
                </div>
            </div>
            <div class="photo-strip-item">
                <img src="{{ asset('images/mother-cooking.png') }}" alt="Ibu memasak bersama anak">
                <div class="photo-strip-caption">
                    Memasak Bersama
                </div>
            </div>
            <div class="photo-strip-item">
                <img src="{{ asset('images/family-meal.png') }}" alt="Keluarga makan bersama">
                <div class="photo-strip-caption">
                    Keluarga Sehat
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Kategori</div>
            <h2>Resep Berdasarkan <span>Kelompok Usia</span></h2>
            <p>Pilih kategori sesuai usia anak untuk menemukan resep yang tepat</p>
        </div>
        <div class="categories-grid">
            @foreach($categories as $category)
            <a href="/resep?category={{ $category->id }}" class="category-card">
                <div class="category-card-icon">
                    <span style="font-size: 1.5rem;">{{ Str::substr($category->name, 0, 1) }}</span>
                </div>
                <h4>{{ $category->name }}</h4>
                <p>{{ $category->recipes_count }} resep</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Recipes -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Populer</div>
            <h2>Resep <span>Terbaru</span></h2>
            <p>Koleksi resep bergizi yang baru ditambahkan untuk tumbuh kembang anak</p>
        </div>
        <div class="recipes-grid">
            @foreach($featured_recipes as $recipe)
            <div class="recipe-card">
                <div class="recipe-card-image">
                    @if($recipe->image)
                        <img src="{{ asset($recipe->image) }}" alt="{{ $recipe->title }}">
                    @endif
                    <span class="recipe-card-badge">{{ $recipe->category->name ?? 'Umum' }}</span>
                </div>
                <div class="recipe-card-body">
                    <h3><a href="/resep/{{ $recipe->slug }}">{{ $recipe->title }}</a></h3>
                    <p>{{ $recipe->description }}</p>
                    <div class="recipe-card-meta">
                        <span>{{ $recipe->per_serving_nutrition['calories'] ?? 0 }} kkal</span>
                        <span>{{ $recipe->per_serving_nutrition['protein'] ?? 0 }}g protein</span>
                        <span>{{ $recipe->servings }} porsi</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div style="text-align: center; margin-top: 2.5rem;">
            <a href="/resep" class="btn btn-primary btn-lg">Lihat Semua Resep</a>
        </div>
    </div>
</section>

<!-- Stunting Awareness Section with Image -->
<section class="section stunting-section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Edukasi</div>
            <h2>Cegah <span>Stunting</span> Sejak Dini</h2>
            <p>Stunting adalah gangguan pertumbuhan yang dapat dicegah dengan nutrisi yang tepat</p>
        </div>
        <div class="stunting-content">
            <div class="stunting-image">
                <img src="{{ asset('images/baby-eating.png') }}" alt="Bayi sehat makan MPASI">
                <div class="stunting-image-badge">
                    1000 Hari Pertama
                </div>
            </div>
            <div class="info-cards-vertical">
                <div class="info-card">
                    <div class="info-card-icon">S</div>
                    <div class="info-card-content">
                        <h3>Apa itu Stunting?</h3>
                        <p>Stunting adalah kondisi gagal tumbuh pada anak balita akibat kekurangan gizi kronis, ditandai dengan tinggi badan di bawah standar usia.</p>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-card-icon" style="background: var(--accent-50); color: var(--accent-600);">N</div>
                    <div class="info-card-content">
                        <h3>Nutrisi Penting</h3>
                        <p>Protein, zat besi, kalsium, vitamin A, dan zinc adalah nutrisi kunci yang harus tercukupi untuk mencegah stunting pada anak.</p>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-card-icon" style="background: #eff6ff; color: var(--info);">1K</div>
                    <div class="info-card-content">
                        <h3>1000 Hari Pertama</h3>
                        <p>Periode 1000 hari pertama kehidupan adalah masa emas untuk memastikan nutrisi optimal demi pertumbuhan yang sehat.</p>
                    </div>
                </div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 2.5rem;">
            <a href="/stunting" class="btn btn-outline btn-lg">Pelajari Lebih Lanjut</a>
        </div>
    </div>
</section>

<!-- CTA Section with Background Image -->
<section class="cta-section">
    <div class="cta-bg-image">
        <img src="{{ asset('images/family-meal.png') }}" alt="Keluarga menikmati makanan bergizi bersama">
        <div class="cta-overlay"></div>
    </div>
    <div class="container" style="position: relative; z-index: 2;">
        <div class="cta-content">
            <h2>Hitung Kebutuhan Gizi Anak Anda</h2>
            <p>Gunakan kalkulator gizi kami untuk mengetahui kandungan nutrisi dari bahan makanan yang Anda pilih.</p>
            <a href="/kalkulator" class="btn btn-white btn-lg">Buka Kalkulator Gizi</a>
        </div>
    </div>
</section>
@endsection
