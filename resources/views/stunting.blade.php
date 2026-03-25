@extends('layouts.public')
@section('title', 'Cegah Stunting — Informasi & Edukasi | CETING NASIKU')
@section('meta_description', 'Pelajari tentang stunting, penyebab, pencegahan, dan nutrisi penting untuk tumbuh kembang anak. Cegah stunting sejak dini dengan gizi seimbang.')

@section('content')
<!-- Hero with Background Photo -->
<section class="stunting-hero stunting-hero--photo">
    <div class="stunting-hero__bg">
        <img src="{{ asset('images/stunting-hero.png') }}" alt="Pemeriksaan tumbuh kembang anak di Posyandu">
        <div class="stunting-hero__overlay"></div>
    </div>
    <div class="container" style="position: relative; z-index: 2;">
        <div class="section-badge section-badge-hero">
            <i class="fas fa-heart-pulse"></i> Edukasi Kesehatan
        </div>
        <h1>Cegah Stunting <span>Sejak Dini</span></h1>
        <p>Pahami penyebab, dampak, dan cara mencegah stunting pada anak melalui pemenuhan gizi seimbang di 1000 hari pertama kehidupan.</p>
        <div class="stunting-hero__actions">
            <a href="#apa-stunting" class="btn btn-white btn-lg"><i class="fas fa-arrow-down"></i> Pelajari Sekarang</a>
            <a href="/kalkulator" class="btn btn-accent btn-lg"><i class="fas fa-calculator"></i> Kalkulator Gizi</a>
        </div>
    </div>
</section>

<!-- Quick Stats Banner -->
<section class="stunting-stats-banner">
    <div class="container">
        <div class="stunting-stats-grid">
            <div class="stunting-stat-item">
                <div class="stunting-stat-icon"><i class="fas fa-globe-asia"></i></div>
                <div>
                    <div class="stunting-stat-number">21,6%</div>
                    <div class="stunting-stat-desc">Prevalensi stunting di Indonesia (2022)</div>
                </div>
            </div>
            <div class="stunting-stat-item">
                <div class="stunting-stat-icon" style="background: var(--accent-50); color: var(--accent-600);"><i class="fas fa-baby"></i></div>
                <div>
                    <div class="stunting-stat-number">1000</div>
                    <div class="stunting-stat-desc">Hari pertama kehidupan adalah masa emas</div>
                </div>
            </div>
            <div class="stunting-stat-item">
                <div class="stunting-stat-icon" style="background: #eff6ff; color: var(--info);"><i class="fas fa-shield-heart"></i></div>
                <div>
                    <div class="stunting-stat-number">100%</div>
                    <div class="stunting-stat-desc">Stunting dapat dicegah dengan gizi tepat</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- What is Stunting -->
<section class="section" id="apa-stunting">
    <div class="container">
        <div class="stunting-split">
            <div class="stunting-split__image">
                <img src="{{ asset('images/healthy-child.png') }}" alt="Anak sehat makan makanan bergizi">
                <div class="stunting-split__badge">
                    <i class="fas fa-child"></i> Tumbuh Kembang Optimal
                </div>
            </div>
            <div class="stunting-split__text">
                <div class="section-badge"><i class="fas fa-question-circle"></i> Pengetahuan Dasar</div>
                <h2>Apa Itu <span>Stunting?</span></h2>
                <p>Stunting adalah kondisi gagal tumbuh pada anak balita (bayi di bawah lima tahun) akibat dari kekurangan gizi kronis sehingga anak menjadi terlalu pendek untuk usianya.</p>
                <p>Kekurangan gizi terjadi sejak bayi dalam kandungan dan pada masa awal setelah bayi lahir. Namun, kondisi stunting baru nampak setelah bayi berusia 2 tahun.</p>
                <div class="nutrition-highlight">
                    <h4><i class="fas fa-chart-bar"></i> Fakta Penting</h4>
                    <p>Menurut WHO, Indonesia termasuk negara dengan prevalensi stunting cukup tinggi. Stunting dapat dicegah dengan intervensi gizi yang tepat selama 1000 hari pertama kehidupan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Causes -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <div class="section-badge"><i class="fas fa-magnifying-glass"></i> Penyebab</div>
            <h2>Penyebab <span>Stunting</span></h2>
            <p>Berbagai faktor yang berkontribusi terhadap terjadinya stunting pada anak</p>
        </div>
        <div class="stunting-causes-grid">
            <div class="stunting-cause-card">
                <div class="stunting-cause-num">01</div>
                <div class="stunting-cause-icon" style="background: #fef2f2; color: var(--danger);"><i class="fas fa-utensils"></i></div>
                <h3>Kurang Gizi Kronis</h3>
                <p>Asupan makanan yang tidak memenuhi kebutuhan gizi dalam jangka waktu yang panjang, terutama protein, zat besi, dan zinc.</p>
            </div>
            <div class="stunting-cause-card">
                <div class="stunting-cause-num">02</div>
                <div class="stunting-cause-icon" style="background: var(--accent-50); color: var(--accent-600);"><i class="fas fa-viruses"></i></div>
                <h3>Infeksi Berulang</h3>
                <p>Penyakit infeksi yang sering terjadi seperti diare dan ISPA dapat mengganggu penyerapan nutrisi dalam tubuh anak.</p>
            </div>
            <div class="stunting-cause-card">
                <div class="stunting-cause-num">03</div>
                <div class="stunting-cause-icon" style="background: #eff6ff; color: var(--info);"><i class="fas fa-person-pregnant"></i></div>
                <h3>Gizi Ibu Hamil</h3>
                <p>Kondisi kurang gizi pada ibu selama kehamilan sangat berpengaruh terhadap pertumbuhan janin dan risiko stunting pada anak.</p>
            </div>
            <div class="stunting-cause-card">
                <div class="stunting-cause-num">04</div>
                <div class="stunting-cause-icon" style="background: #faf5ff; color: #9333ea;"><i class="fas fa-droplet"></i></div>
                <h3>Sanitasi & Air Bersih</h3>
                <p>Akses terhadap sanitasi yang buruk dan air bersih yang terbatas meningkatkan risiko penyakit dan gangguan pertumbuhan.</p>
            </div>
            <div class="stunting-cause-card">
                <div class="stunting-cause-num">05</div>
                <div class="stunting-cause-icon" style="background: #fefce8; color: #ca8a04;"><i class="fas fa-baby-carriage"></i></div>
                <h3>Pola Asuh</h3>
                <p>Praktik pemberian makan yang kurang tepat, seperti pemberian MPASI yang terlalu dini atau terlalu lambat.</p>
            </div>
            <div class="stunting-cause-card">
                <div class="stunting-cause-num">06</div>
                <div class="stunting-cause-icon"><i class="fas fa-house-chimney-crack"></i></div>
                <h3>Faktor Lingkungan</h3>
                <p>Kondisi ekonomi keluarga, tingkat pendidikan orang tua, dan akses terhadap layanan kesehatan yang terbatas.</p>
            </div>
        </div>
    </div>
</section>

<!-- Prevention with Image -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge"><i class="fas fa-shield-heart"></i> Pencegahan</div>
            <h2>Cara <span>Mencegah Stunting</span></h2>
            <p>Langkah-langkah penting yang dapat dilakukan untuk mencegah stunting pada anak</p>
        </div>

        <div class="stunting-prevention-grid">
            <div class="stunting-prevention-card">
                <div class="stunting-prevention-step">1</div>
                <div class="stunting-prevention-icon"><i class="fas fa-apple-whole"></i></div>
                <h3>Penuhi Gizi Seimbang</h3>
                <p>Berikan makanan bergizi seimbang yang mengandung karbohidrat, protein, lemak, vitamin, dan mineral sesuai kebutuhan usia anak.</p>
                <ul>
                    <li><i class="fas fa-check"></i> Sumber protein (telur, ikan, daging, tempe, tahu)</li>
                    <li><i class="fas fa-check"></i> Sayuran hijau dan buah-buahan</li>
                    <li><i class="fas fa-check"></i> Sumber karbohidrat (nasi, kentang, ubi)</li>
                    <li><i class="fas fa-check"></i> Susu dan produk olahannya</li>
                </ul>
            </div>
            <div class="stunting-prevention-card">
                <div class="stunting-prevention-step">2</div>
                <div class="stunting-prevention-icon" style="background: var(--accent-50); color: var(--accent-600);"><i class="fas fa-heart"></i></div>
                <h3>ASI Eksklusif</h3>
                <p>Berikan Air Susu Ibu (ASI) secara eksklusif selama 6 bulan pertama, dilanjutkan dengan MPASI yang bergizi sambil tetap memberikan ASI hingga usia 2 tahun.</p>
            </div>
            <div class="stunting-prevention-card">
                <div class="stunting-prevention-step">3</div>
                <div class="stunting-prevention-icon" style="background: #eff6ff; color: var(--info);"><i class="fas fa-stethoscope"></i></div>
                <h3>Pemeriksaan Rutin</h3>
                <p>Lakukan pemeriksaan kesehatan rutin di Posyandu atau Puskesmas untuk memantau pertumbuhan dan perkembangan anak secara berkala.</p>
            </div>
            <div class="stunting-prevention-card">
                <div class="stunting-prevention-step">4</div>
                <div class="stunting-prevention-icon" style="background: #faf5ff; color: #9333ea;"><i class="fas fa-hand-holding-droplet"></i></div>
                <h3>Sanitasi & Kebersihan</h3>
                <p>Jaga kebersihan lingkungan, cuci tangan sebelum menyiapkan makanan, dan pastikan air minum yang digunakan bersih dan aman.</p>
            </div>
        </div>
    </div>
</section>

<!-- Important Nutrients with Photo -->
<section class="section stunting-nutrients-section">
    <div class="container">
        <div class="stunting-nutrients-layout">
            <div class="stunting-nutrients-image">
                <img src="{{ asset('images/fresh-nutrition.png') }}" alt="Bahan makanan bergizi untuk mencegah stunting">
                <div class="stunting-nutrients-image-badge">
                    <i class="fas fa-leaf"></i> Bahan Alami & Bernutrisi
                </div>
            </div>
            <div class="stunting-nutrients-content">
                <div class="section-badge"><i class="fas fa-dna"></i> Nutrisi Kunci</div>
                <h2>Nutrisi Penting untuk <span>Mencegah Stunting</span></h2>
                <div class="stunting-nutrient-list">
                    @php
                    $nutrients = [
                    ['icon' => 'fas fa-drumstick-bite', 'name' => 'Protein', 'desc' => 'Membangun dan memperbaiki jaringan tubuh, penting untuk pertumbuhan otot dan organ.', 'source' => 'Telur, ikan, daging, tempe, tahu', 'color' => 'var(--primary-600)'],
                    ['icon' => 'fas fa-magnet', 'name' => 'Zat Besi', 'desc' => 'Membentuk hemoglobin untuk mengangkut oksigen dan mencegah anemia.', 'source' => 'Bayam, daging merah, hati ayam', 'color' => 'var(--danger)'],
                    ['icon' => 'fas fa-bone', 'name' => 'Kalsium', 'desc' => 'Pembentukan tulang dan gigi yang kuat serta fungsi saraf dan otot.', 'source' => 'Susu, keju, ikan teri, brokoli', 'color' => '#ca8a04'],
                    ['icon' => 'fas fa-eye', 'name' => 'Vitamin A', 'desc' => 'Mendukung kesehatan mata, sistem imun, dan pertumbuhan sel tubuh.', 'source' => 'Wortel, ubi jalar, bayam, telur', 'color' => 'var(--accent-600)'],
                    ['icon' => 'fas fa-lemon', 'name' => 'Vitamin C', 'desc' => 'Meningkatkan daya tahan tubuh dan membantu penyerapan zat besi.', 'source' => 'Jeruk, jambu biji, tomat', 'color' => '#16a34a'],
                    ['icon' => 'fas fa-atom', 'name' => 'Zinc', 'desc' => 'Berperan dalam pertumbuhan sel, fungsi imun, dan penyembuhan luka.', 'source' => 'Daging, kacang-kacangan, biji-bijian', 'color' => 'var(--info)'],
                    ];
                    @endphp

                    @foreach($nutrients as $nutrient)
                    <div class="stunting-nutrient-item">
                        <div class="stunting-nutrient-icon" style="color: {{ $nutrient['color'] }};">
                            <i class="{{ $nutrient['icon'] }}"></i>
                        </div>
                        <div class="stunting-nutrient-info">
                            <h4>{{ $nutrient['name'] }}</h4>
                            <p>{{ $nutrient['desc'] }}</p>
                            <span class="stunting-nutrient-source"><i class="fas fa-seedling"></i> {{ $nutrient['source'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA with Background Image -->
<section class="cta-section">
    <div class="cta-bg-image">
        <img src="{{ asset('images/mother-cooking.png') }}" alt="Ibu memasak makanan bergizi bersama anak">
        <div class="cta-overlay"></div>
    </div>
    <div class="container" style="position: relative; z-index: 2;">
        <div class="cta-content">
            <h2>Mulai Hitung Kebutuhan Gizi Anak Anda</h2>
            <p>Gunakan kalkulator gizi kami untuk memastikan menu harian anak memenuhi kebutuhan nutrisi. Atau temukan resep bergizi yang mudah dan praktis.</p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="/kalkulator" class="btn btn-white btn-lg"><i class="fas fa-calculator"></i> Kalkulator Gizi</a>
                <a href="/resep" class="btn btn-accent btn-lg"><i class="fas fa-utensils"></i> Lihat Resep</a>
            </div>
        </div>
    </div>
</section>
@endsection