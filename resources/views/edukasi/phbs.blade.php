@extends('layouts.public')
@section('title', 'PHBS — Perilaku Hidup Bersih dan Sehat | CETING NASIKU')
@section('meta_description', 'Panduan PHBS untuk keluarga: cuci tangan, air bersih, sanitasi, kebersihan makanan, dan lingkungan sehat untuk mencegah stunting.')

@section('content')
<!-- Hero -->
<section class="edu-hero edu-hero--compact">
    <div class="edu-hero__bg">
        <img src="{{ asset('images/phbs.png') }}" alt="Ibu mengajarkan anak cuci tangan yang benar">
        <div class="edu-hero__overlay"></div>
    </div>
    <div class="container" style="position: relative; z-index: 2;">
        <a href="/edukasi" class="edu-breadcrumb"><i class="fas fa-arrow-left"></i> Kembali ke Modul Edukasi</a>
        <div class="section-badge section-badge-hero">
            <i class="fas fa-hand-sparkles"></i> Modul Edukasi
        </div>
        <h1>Perilaku Hidup <span>Bersih & Sehat</span></h1>
        <p>PHBS adalah sekumpulan perilaku kesehatan yang dilakukan atas dasar kesadaran untuk mencegah penyakit dan meningkatkan kualitas hidup keluarga.</p>
    </div>
</section>

<!-- Content -->
<div class="edu-article">
    <div class="container">
        <div class="edu-article-layout">
            <!-- Main Content -->
            <div class="edu-article-main">

                <!-- Section 1: Cuci Tangan -->
                <div class="edu-article-section" id="cuci-tangan">
                    <div class="edu-article-section-num">01</div>
                    <h2><i class="fas fa-hands-bubbles" style="color: var(--info);"></i> Cuci Tangan Pakai Sabun (CTPS)</h2>
                    <p>Cuci tangan pakai sabun adalah cara paling efektif dan murah untuk mencegah penyebaran kuman penyebab diare dan infeksi saluran pernapasan yang dapat menghambat pertumbuhan anak.</p>

                    <div class="edu-highlight-box">
                        <h4><i class="fas fa-clock"></i> 5 Waktu Penting Cuci Tangan</h4>
                        <div class="edu-checklist">
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Sebelum makan dan menyuapi anak</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Sebelum menyiapkan makanan/memasak</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Setelah buang air besar/kecil</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Setelah mengganti popok bayi</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Setelah memegang hewan atau benda kotor</div>
                        </div>
                    </div>

                    <div class="edu-timeline">
                        <div class="edu-timeline-item">
                            <div class="edu-timeline-marker">1</div>
                            <div class="edu-timeline-content">
                                <h4>Basahi Tangan</h4>
                                <p>Basahi kedua tangan dengan air mengalir yang bersih.</p>
                            </div>
                        </div>
                        <div class="edu-timeline-item">
                            <div class="edu-timeline-marker">2</div>
                            <div class="edu-timeline-content">
                                <h4>Sabuni & Gosok</h4>
                                <p>Ambil sabun secukupnya, gosok kedua telapak tangan, punggung tangan, sela-sela jari, dan kuku minimal 20 detik.</p>
                            </div>
                        </div>
                        <div class="edu-timeline-item">
                            <div class="edu-timeline-marker">3</div>
                            <div class="edu-timeline-content">
                                <h4>Bilas & Keringkan</h4>
                                <p>Bilas dengan air mengalir hingga bersih, keringkan dengan handuk bersih atau tisu.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: ASI Eksklusif -->
                <div class="edu-article-section" id="asi-phbs">
                    <div class="edu-article-section-num">02</div>
                    <h2><i class="fas fa-heart" style="color: var(--danger);"></i> ASI Eksklusif sebagai PHBS</h2>
                    <p>Pemberian ASI eksklusif selama 6 bulan pertama merupakan salah satu indikator PHBS dalam rumah tangga. ASI memberikan perlindungan alami bagi bayi dari berbagai penyakit.</p>

                    <div class="edu-grid-2col">
                        <div class="edu-mini-card">
                            <div class="edu-mini-card-icon" style="background: #fef2f2; color: var(--danger);"><i class="fas fa-shield-virus"></i></div>
                            <h4>Perlindungan Imun</h4>
                            <p>ASI mengandung antibodi (IgA) yang melindungi saluran cerna bayi dari infeksi bakteri dan virus penyebab diare.</p>
                        </div>
                        <div class="edu-mini-card">
                            <div class="edu-mini-card-icon"><i class="fas fa-seedling"></i></div>
                            <h4>Pertumbuhan Optimal</h4>
                            <p>Nutrisi dalam ASI disesuaikan secara alami dengan kebutuhan bayi sehingga mendukung pertumbuhan dan perkembangan optimal.</p>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Air Bersih & Sanitasi -->
                <div class="edu-article-section" id="air-bersih">
                    <div class="edu-article-section-num">03</div>
                    <h2><i class="fas fa-droplet" style="color: var(--primary-600);"></i> Air Bersih & Sanitasi</h2>
                    <p>Akses terhadap air bersih dan sanitasi yang memadai merupakan faktor penting dalam mencegah penyakit diare dan infeksi yang dapat menyebabkan stunting.</p>

                    <div class="edu-highlight-box" style="border-left-color: var(--primary-500);">
                        <h4><i class="fas fa-water"></i> Kriteria Air Bersih</h4>
                        <div class="edu-checklist">
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Tidak berwarna (jernih) dan tidak berbau</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Tidak berasa (tawar)</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Bebas dari kuman dan zat berbahaya</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Memenuhi standar kesehatan yang ditetapkan</div>
                        </div>
                    </div>

                    <div class="edu-warning-box">
                        <div class="edu-tip-icon" style="background: #fef2f2; color: var(--danger);"><i class="fas fa-exclamation-triangle"></i></div>
                        <div>
                            <strong>Perhatian:</strong> Selalu masak air hingga mendidih sebelum diminum. Simpan air minum dalam wadah tertutup yang bersih. Jangan mencampur air mentah dengan air matang.
                        </div>
                    </div>
                </div>

                <!-- Section 4: Kebersihan Makanan -->
                <div class="edu-article-section" id="kebersihan-makanan">
                    <div class="edu-article-section-num">04</div>
                    <h2><i class="fas fa-utensils" style="color: var(--accent-600);"></i> Kebersihan Makanan</h2>
                    <p>Penanganan makanan yang higienis sangat penting untuk mencegah kontaminasi bakteri yang menyebabkan diare dan infeksi pada anak.</p>

                    <div class="edu-grid-2col">
                        <div class="edu-mini-card">
                            <div class="edu-mini-card-icon" style="background: var(--accent-50); color: var(--accent-600);"><i class="fas fa-carrot"></i></div>
                            <h4>Bahan Segar</h4>
                            <p>Pilih bahan makanan yang segar dan berkualitas. Cuci sayuran dan buah dengan air mengalir sebelum diolah.</p>
                        </div>
                        <div class="edu-mini-card">
                            <div class="edu-mini-card-icon" style="background: #fef2f2; color: var(--danger);"><i class="fas fa-temperature-high"></i></div>
                            <h4>Masak Matang</h4>
                            <p>Masak makanan hingga matang sempurna, terutama daging, telur, dan ikan. Hindari makanan setengah matang untuk anak.</p>
                        </div>
                        <div class="edu-mini-card">
                            <div class="edu-mini-card-icon" style="background: #eff6ff; color: var(--info);"><i class="fas fa-box"></i></div>
                            <h4>Penyimpanan Benar</h4>
                            <p>Simpan makanan dalam wadah tertutup. Pisahkan bahan mentah dari makanan matang. Gunakan kulkas jika memungkinkan.</p>
                        </div>
                        <div class="edu-mini-card">
                            <div class="edu-mini-card-icon" style="background: #faf5ff; color: #9333ea;"><i class="fas fa-plate-wheat"></i></div>
                            <h4>Penyajian Higienis</h4>
                            <p>Gunakan peralatan makan yang bersih. Sajikan makanan dalam keadaan hangat. Jangan biarkan makanan terbuka terlalu lama.</p>
                        </div>
                    </div>
                </div>

                <!-- Section 5: Lingkungan Bersih -->
                <div class="edu-article-section" id="lingkungan-bersih">
                    <div class="edu-article-section-num">05</div>
                    <h2><i class="fas fa-house-chimney" style="color: #16a34a;"></i> Lingkungan Bersih & Sehat</h2>
                    <p>Lingkungan rumah yang bersih dan sehat berperan penting dalam menjaga kesehatan anak dan seluruh keluarga.</p>

                    <div class="edu-highlight-box" style="border-left-color: #16a34a;">
                        <h4><i class="fas fa-broom"></i> Checklist Lingkungan Sehat</h4>
                        <div class="edu-checklist">
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Gunakan jamban/toilet yang bersih dan terawat</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Buang sampah pada tempatnya dan kelola dengan benar</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Pastikan ventilasi rumah baik agar udara segar</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Bersihkan lantai dan perabotan secara rutin</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Cegah genangan air untuk menghindari nyamuk</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Jauhkan anak dari asap rokok dan polusi</div>
                        </div>
                    </div>

                    <div class="edu-tip-box">
                        <div class="edu-tip-icon"><i class="fas fa-lightbulb"></i></div>
                        <div>
                            <strong>Tips:</strong> Libatkan anak dalam kegiatan kebersihan sederhana sesuai usianya, seperti membuang sampah, merapikan mainan, dan menyapu. Ini membantu membentuk kebiasaan sehat sejak dini.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="edu-article-sidebar">
                <div class="edu-sidebar-card">
                    <h4><i class="fas fa-list"></i> Daftar Materi</h4>
                    <nav class="edu-sidebar-nav">
                        <a href="#cuci-tangan"><i class="fas fa-hands-bubbles"></i> Cuci Tangan Pakai Sabun</a>
                        <a href="#asi-phbs"><i class="fas fa-heart"></i> ASI Eksklusif</a>
                        <a href="#air-bersih"><i class="fas fa-droplet"></i> Air Bersih & Sanitasi</a>
                        <a href="#kebersihan-makanan"><i class="fas fa-utensils"></i> Kebersihan Makanan</a>
                        <a href="#lingkungan-bersih"><i class="fas fa-house-chimney"></i> Lingkungan Bersih</a>
                    </nav>
                </div>

                <div class="edu-sidebar-card edu-sidebar-card--accent">
                    <h4><i class="fas fa-utensils"></i> Resep Sehat</h4>
                    <p>Temukan resep makanan bergizi yang mudah dan praktis untuk keluarga.</p>
                    <a href="/resep" class="btn btn-primary btn-sm" style="width: 100%; justify-content: center;">Lihat Resep</a>
                </div>

                <div class="edu-sidebar-card">
                    <h4><i class="fas fa-book-open"></i> Modul Lainnya</h4>
                    <nav class="edu-sidebar-nav">
                        <a href="/edukasi/pola-asuh"><i class="fas fa-baby"></i> Pola Asuh Anak</a>
                        <a href="/edukasi/kehamilan"><i class="fas fa-person-pregnant"></i> Perawatan Kehamilan</a>
                        <a href="/stunting"><i class="fas fa-heart-pulse"></i> Cegah Stunting</a>
                    </nav>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
