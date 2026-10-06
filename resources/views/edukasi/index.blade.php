@extends('layouts.public')
@section('body_class', 'page-inner')
@section('title', 'Modul Edukasi — CETING NASIKU')
@section('meta_description', 'Pelajari pola asuh anak, PHBS, dan perawatan kehamilan untuk mencegah stunting. Edukasi kesehatan dari CETING NASIKU Kab. Tanah Laut.')
@section('og_title', 'Modul Edukasi — CETING NASIKU')
@section('og_description', 'Pelajari pola asuh anak, PHBS, dan perawatan kehamilan untuk mencegah stunting.')
@section('og_type', 'website')

@section('content')
<!-- Hero -->
<section class="edu-hero">
    <div class="edu-hero__bg">
        <img src="{{ asset('images/edukasi-hero.png') }}" alt="Kegiatan edukasi kesehatan di Posyandu">
        <div class="edu-hero__overlay"></div>
    </div>
    <div class="container" style="position: relative; z-index: 2;">
        <div class="section-badge section-badge-hero">
            <i class="fas fa-graduation-cap"></i> Modul Edukasi
        </div>
        <h1>Edukasi Kesehatan <span>Keluarga</span></h1>
        <p>Tingkatkan pengetahuan Anda tentang pola asuh anak, perilaku hidup bersih dan sehat, serta perawatan kehamilan untuk mencegah stunting dan membangun keluarga unggul.</p>
    </div>
</section>

<!-- Module Cards -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge"><i class="fas fa-book-open"></i> Pilih Modul</div>
            <h2>Materi <span>Edukasi</span></h2>
            <p>Pilih modul edukasi yang ingin Anda pelajari</p>
        </div>

        <div class="edu-modules-grid">
            <!-- Pola Asuh -->
            <a href="/edukasi/pola-asuh" class="edu-module-card">
                <div class="edu-module-card__image">
                    <img src="{{ asset('images/pola-asuh.png') }}" alt="Pola asuh anak yang benar">
                    <div class="edu-module-card__badge"><i class="fas fa-baby"></i> 5 Materi</div>
                </div>
                <div class="edu-module-card__body">
                    <div class="edu-module-card__icon"><i class="fas fa-baby"></i></div>
                    <h3>Pola Asuh Anak</h3>
                    <p>Panduan lengkap pemberian ASI eksklusif, MPASI, jadwal makan, stimulasi tumbuh kembang, dan imunisasi untuk anak sehat.</p>
                    <span class="edu-module-card__link">Pelajari <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            <!-- PHBS -->
            <a href="/edukasi/phbs" class="edu-module-card">
                <div class="edu-module-card__image">
                    <img src="{{ asset('images/phbs.png') }}" alt="Perilaku Hidup Bersih dan Sehat">
                    <div class="edu-module-card__badge"><i class="fas fa-hand-sparkles"></i> 5 Materi</div>
                </div>
                <div class="edu-module-card__body">
                    <div class="edu-module-card__icon" style="background: var(--accent-50); color: var(--accent-600);"><i class="fas fa-hand-sparkles"></i></div>
                    <h3>PHBS</h3>
                    <p>Perilaku Hidup Bersih dan Sehat: cuci tangan, sanitasi, air bersih, kebersihan makanan, dan lingkungan sehat untuk keluarga.</p>
                    <span class="edu-module-card__link">Pelajari <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            <!-- Kehamilan -->
            <a href="/edukasi/kehamilan" class="edu-module-card">
                <div class="edu-module-card__image">
                    <img src="{{ asset('images/kehamilan.png') }}" alt="Perawatan kehamilan">
                    <div class="edu-module-card__badge"><i class="fas fa-heart"></i> 5 Materi</div>
                </div>
                <div class="edu-module-card__body">
                    <div class="edu-module-card__icon" style="background: var(--primary-50); color: var(--info);"><i class="fas fa-person-pregnant"></i></div>
                    <h3>Perawatan Kehamilan</h3>
                    <p>Panduan pemeriksaan ANC, nutrisi ibu hamil, tanda bahaya kehamilan, persiapan persalinan, dan 1000 hari pertama kehidupan.</p>
                    <span class="edu-module-card__link">Pelajari <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Quick Info -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <div class="section-badge"><i class="fas fa-lightbulb"></i> Tahukah Anda?</div>
            <h2>Mengapa Edukasi <span>Penting?</span></h2>
        </div>
        <div class="edu-why-grid">
            <div class="edu-why-card">
                <div class="edu-why-num">01</div>
                <h4>Pencegahan Lebih Baik</h4>
                <p>Stunting dapat dicegah jika orang tua memiliki pengetahuan yang cukup tentang gizi dan pola asuh anak sejak dini.</p>
            </div>
            <div class="edu-why-card">
                <div class="edu-why-num">02</div>
                <h4>1000 Hari Pertama</h4>
                <p>Periode emas pertumbuhan dimulai sejak kehamilan hingga usia 2 tahun. Pemahaman ibu hamil tentang nutrisi sangat krusial.</p>
            </div>
            <div class="edu-why-card">
                <div class="edu-why-num">03</div>
                <h4>Kebiasaan Sehat</h4>
                <p>PHBS yang diterapkan secara konsisten dalam keluarga dapat menurunkan risiko infeksi dan gangguan pertumbuhan pada anak.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="cta-bg-image">
        <img src="{{ asset('images/family-meal.png') }}" alt="Keluarga sehat makan bersama">
        <div class="cta-overlay"></div>
    </div>
    <div class="container" style="position: relative; z-index: 2;">
        <div class="cta-content">
            <h2>Ingin Menghitung Kebutuhan Gizi?</h2>
            <p>Gunakan kalkulator gizi kami untuk memastikan menu harian anak dan keluarga Anda memenuhi kebutuhan nutrisi.</p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="/kalkulator" class="btn btn-white btn-lg"><i class="fas fa-calculator"></i> Kalkulator Gizi</a>
                <a href="/resep" class="btn btn-accent btn-lg"><i class="fas fa-utensils"></i> Lihat Resep</a>
            </div>
        </div>
    </div>
</section>
@endsection