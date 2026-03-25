@extends('layouts.public')
@section('title', 'Pola Asuh Anak — Modul Edukasi | CETING NASIKU')
@section('meta_description', 'Panduan pola asuh anak yang benar untuk mencegah stunting. Pelajari ASI eksklusif, MPASI, jadwal makan, stimulasi tumbuh kembang, dan imunisasi.')

@section('content')
<!-- Hero -->
<section class="edu-hero edu-hero--compact">
    <div class="edu-hero__bg">
        <img src="{{ asset('images/pola-asuh.png') }}" alt="Ibu memberi makan anak dengan MPASI bergizi">
        <div class="edu-hero__overlay"></div>
    </div>
    <div class="container" style="position: relative; z-index: 2;">
        <a href="/edukasi" class="edu-breadcrumb"><i class="fas fa-arrow-left"></i> Kembali ke Modul Edukasi</a>
        <div class="section-badge section-badge-hero">
            <i class="fas fa-baby"></i> Modul Edukasi
        </div>
        <h1>Pola Asuh <span>Anak</span></h1>
        <p>Panduan lengkap pola asuh anak yang benar untuk mendukung tumbuh kembang optimal dan mencegah stunting sejak dini.</p>
    </div>
</section>

<!-- Content -->
<div class="edu-article">
    <div class="container">
        <div class="edu-article-layout">
            <!-- Main Content -->
            <div class="edu-article-main">

                <!-- Section 1: ASI Eksklusif -->
                <div class="edu-article-section" id="asi-eksklusif">
                    <div class="edu-article-section-num">01</div>
                    <h2><i class="fas fa-heart" style="color: var(--danger);"></i> ASI Eksklusif 6 Bulan</h2>
                    <p>Air Susu Ibu (ASI) adalah makanan terbaik untuk bayi sejak lahir hingga usia 6 bulan. ASI mengandung semua nutrisi yang diperlukan bayi dan antibodi untuk melindungi dari penyakit.</p>

                    <div class="edu-highlight-box">
                        <h4><i class="fas fa-star"></i> Manfaat ASI Eksklusif</h4>
                        <div class="edu-checklist">
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Mengandung antibodi alami untuk menjaga daya tahan tubuh bayi</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Nutrisi lengkap dan seimbang sesuai kebutuhan bayi</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Mudah dicerna oleh sistem pencernaan bayi yang belum sempurna</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Mempererat ikatan emosional ibu dan bayi (bonding)</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> Mengurangi risiko infeksi, alergi, dan penyakit kronis</div>
                        </div>
                    </div>

                    <div class="edu-tip-box">
                        <div class="edu-tip-icon"><i class="fas fa-lightbulb"></i></div>
                        <div>
                            <strong>Tips:</strong> Inisiasi Menyusu Dini (IMD) sebaiknya dilakukan dalam 1 jam pertama setelah bayi lahir. Susui bayi setiap kali bayi menunjukkan tanda lapar (on demand), minimal 8-12 kali per hari.
                        </div>
                    </div>
                </div>

                <!-- Section 2: MPASI -->
                <div class="edu-article-section" id="mpasi">
                    <div class="edu-article-section-num">02</div>
                    <h2><i class="fas fa-utensils" style="color: var(--accent-600);"></i> MPASI Sesuai "Isi Piringku"</h2>
                    <p>Mulai usia 6 bulan, kebutuhan nutrisi bayi meningkat dan ASI saja tidak mencukupi, sehingga perlu diberikan Makanan Pendamping ASI (MPASI). Berikan MPASI yang bergizi seimbang dengan mempedomani konsep <strong>"Isi Piringku"</strong> untuk mencegah stunting.</p>

                    <div class="edu-highlight-box" style="margin-bottom: 2rem;">
                        <h4><i class="fas fa-utensils"></i> Panduan "Isi Piringku" untuk MPASI</h4>
                        <p style="font-size: 0.9rem; margin-bottom: 1rem;">Pastikan setiap porsi makan anak mengandung 4 unsur nutrisi utama berikut:</p>
                        <div class="edu-checklist">
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> <strong>Makanan Pokok (35%):</strong> Sumber karbohidrat sebagai penghasil energi. (Contoh: beras, kentang, singkong, jagung, sagu)</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> <strong>Lauk Pauk Hewani (30%):</strong> Sumber protein utama untuk pertumbuhan sel & otak. Sangat esensial cegah stunting! (Contoh: telur, ayam, ikan, daging sapi, hati ayam)</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> <strong>Lauk Pauk Nabati (10%):</strong> Sumber protein tambahan dari tumbuhan. (Contoh: tempe, tahu, kacang-kacangan)</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> <strong>Sayur & Buah (25%):</strong> Sumber vitamin dan mineral untuk imunitas, namun cukup berikan secukupnya untuk pengenalan tekstur & rasa.</div>
                        </div>
                    </div>

                    <div class="edu-timeline">
                        <div class="edu-timeline-item">
                            <div class="edu-timeline-marker">6 bln</div>
                            <div class="edu-timeline-content">
                                <h4>Usia 6 Bulan (Awal MPASI)</h4>
                                <p>Mulai dengan makanan lumat/halus (puree). Tekstur sangat lembut. Berikan 2-3 sendok makan, 2-3 kali sehari. Tambahkan sedikit lemak tambahan (minyak kelapa, santan, atau mentega tak asin) pada makanannya.</p>
                            </div>
                        </div>
                        <div class="edu-timeline-item">
                            <div class="edu-timeline-marker">8 bln</div>
                            <div class="edu-timeline-content">
                                <h4>Usia 8-9 Bulan</h4>
                                <p>Tingkatkan ke makanan lunak/cincang kasar. Berikan 3-4 sendok makan, 3 kali sehari + 1-2 kali snack buatan rumahan. Kenalkan anak dengan tekstur yang sedikit kasar untuk melatihnya mengunyah.</p>
                            </div>
                        </div>
                        <div class="edu-timeline-item">
                            <div class="edu-timeline-marker">12 bln</div>
                            <div class="edu-timeline-content">
                                <h4>Usia 12 Bulan ke Atas</h4>
                                <p>Makanan keluarga yang disesuaikan ukurannya (dipotong kecil-kecil). Berikan 3 kali makan utama + 2 kali snack sehat. Anak mulai belajar makan sendiri dan memegang makanannya sendiri.</p>
                            </div>
                        </div>
                    </div>

                    <div class="edu-warning-box">
                        <div class="edu-tip-icon" style="background: #fef2f2; color: var(--danger);"><i class="fas fa-exclamation-triangle"></i></div>
                        <div>
                            <strong>Penting:</strong> Jangan tunda pemberian Lauk Pauk Hewani pada MPASI. Protein hewani (terutama telur dan ikan laut lokal) sangat penting untuk mencegah gagal tumbuh (stunting) pada rentang 1000 Hari Pertama Kehidupan (HPK).
                        </div>
                    </div>
                </div>

                <!-- Section 3: Jadwal Makan -->
                <div class="edu-article-section" id="jadwal-makan">
                    <div class="edu-article-section-num">03</div>
                    <h2><i class="fas fa-clock" style="color: var(--primary-600);"></i> Jadwal & Porsi Makan Anak</h2>
                    <p>Jadwal makan yang teratur membantu anak mendapatkan nutrisi yang cukup sepanjang hari. Berikut panduan porsi makan berdasarkan usia:</p>

                    <div class="edu-table-responsive">
                        <table class="edu-table">
                            <thead>
                                <tr>
                                    <th>Usia</th>
                                    <th>Frekuensi</th>
                                    <th>Porsi</th>
                                    <th>Tekstur</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>6-8 bulan</strong></td>
                                    <td>2-3x/hari</td>
                                    <td>2-3 sdm per kali</td>
                                    <td>Lumat/halus (puree)</td>
                                </tr>
                                <tr>
                                    <td><strong>9-11 bulan</strong></td>
                                    <td>3-4x/hari</td>
                                    <td>½ mangkuk (125ml)</td>
                                    <td>Cincang halus/kasar</td>
                                </tr>
                                <tr>
                                    <td><strong>12-24 bulan</strong></td>
                                    <td>3x makan + 2x snack</td>
                                    <td>¾ mangkuk (175ml)</td>
                                    <td>Makanan keluarga</td>
                                </tr>
                                <tr>
                                    <td><strong>2-5 tahun</strong></td>
                                    <td>3x makan + 2x snack</td>
                                    <td>1 mangkuk (250ml)</td>
                                    <td>Makanan keluarga</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="edu-tip-box">
                        <div class="edu-tip-icon"><i class="fas fa-lightbulb"></i></div>
                        <div>
                            <strong>Tips:</strong> Pastikan setiap porsi makan mengandung sumber karbohidrat, protein hewani, protein nabati, dan sayuran. Berikan buah sebagai snack sehat di antara waktu makan.
                        </div>
                    </div>
                </div>

                <!-- Section 4: Stimulasi -->
                <div class="edu-article-section" id="stimulasi">
                    <div class="edu-article-section-num">04</div>
                    <h2><i class="fas fa-puzzle-piece" style="color: #9333ea;"></i> Stimulasi Tumbuh Kembang</h2>
                    <p>Selain nutrisi, stimulasi yang tepat juga penting untuk mendukung perkembangan otak, motorik, bahasa, dan sosial anak.</p>

                    <div class="edu-grid-2col">
                        <div class="edu-mini-card">
                            <div class="edu-mini-card-icon"><i class="fas fa-brain"></i></div>
                            <h4>Perkembangan Otak</h4>
                            <p>Ajak anak berbicara, membaca cerita, dan bernyanyi sejak usia dini. Kontak mata dan respon terhadap celoteh bayi sangat penting.</p>
                        </div>
                        <div class="edu-mini-card">
                            <div class="edu-mini-card-icon" style="background: var(--accent-50); color: var(--accent-600);"><i class="fas fa-hand-holding-heart"></i></div>
                            <h4>Motorik Halus</h4>
                            <p>Berikan mainan yang aman untuk digenggam, menyusun balok, mewarnai, dan bermain playdough untuk melatih koordinasi tangan.</p>
                        </div>
                        <div class="edu-mini-card">
                            <div class="edu-mini-card-icon" style="background: #eff6ff; color: var(--info);"><i class="fas fa-running"></i></div>
                            <h4>Motorik Kasar</h4>
                            <p>Biarkan anak bergerak bebas — tengkurap, merangkak, berjalan, berlari, dan bermain di luar rumah untuk memperkuat otot.</p>
                        </div>
                        <div class="edu-mini-card">
                            <div class="edu-mini-card-icon" style="background: #faf5ff; color: #9333ea;"><i class="fas fa-people-arrows"></i></div>
                            <h4>Sosial & Emosional</h4>
                            <p>Ajak anak bermain bersama teman sebaya, ajarkan berbagi, dan berikan kasih sayang yang konsisten untuk membangun rasa aman.</p>
                        </div>
                    </div>
                </div>

                <!-- Section 5: Imunisasi -->
                <div class="edu-article-section" id="imunisasi">
                    <div class="edu-article-section-num">05</div>
                    <h2><i class="fas fa-syringe" style="color: var(--info);"></i> Pentingnya Imunisasi</h2>
                    <p>Imunisasi melindungi anak dari penyakit berbahaya yang dapat mengganggu pertumbuhan. Anak yang sering sakit berisiko lebih tinggi mengalami stunting.</p>

                    <div class="edu-highlight-box" style="border-left-color: var(--info);">
                        <h4><i class="fas fa-calendar-check"></i> Jadwal Imunisasi Dasar & Lanjutan</h4>
                        <div class="edu-checklist">
                            <div class="edu-checklist-item">
                                <i class="fas fa-check-circle" style="margin-top: 5px;"></i> 
                                <div><strong>0 - 1 Bulan:</strong> Hepatitis B (HB-0), BCG, Polio Oral 1</div>
                            </div>
                            <div class="edu-checklist-item">
                                <i class="fas fa-check-circle" style="margin-top: 5px;"></i> 
                                <div>
                                    <strong>2 - 4 Bulan:</strong><br>
                                    <span style="font-size: 0.85rem; color: var(--text-secondary); display: block; margin-top: 0.25rem;">&bull; <strong>2 Bulan:</strong> DPT-HB-Hib 1, Polio Oral 2, PCV 1, Rotavirus 1</span>
                                    <span style="font-size: 0.85rem; color: var(--text-secondary); display: block; margin-top: 0.15rem;">&bull; <strong>3 Bulan:</strong> DPT-HB-Hib 2, Polio Oral 3, PCV 2, Rotavirus 2</span>
                                    <span style="font-size: 0.85rem; color: var(--text-secondary); display: block; margin-top: 0.15rem;">&bull; <strong>4 Bulan:</strong> DPT-HB-Hib 3, Polio Oral 4, IPV 1, Rotavirus 3</span>
                                </div>
                            </div>
                            <div class="edu-checklist-item">
                                <i class="fas fa-check-circle" style="margin-top: 5px;"></i> 
                                <div>
                                    <strong>9 - 12 Bulan:</strong><br>
                                    <span style="font-size: 0.85rem; color: var(--text-secondary); display: block; margin-top: 0.25rem;">&bull; <strong>9 Bulan:</strong> Campak/MR, Polio Suntik (IPV 2)</span>
                                    <span style="font-size: 0.85rem; color: var(--text-secondary); display: block; margin-top: 0.15rem;">&bull; <strong>12 Bulan:</strong> PCV 3</span>
                                </div>
                            </div>
                            <div class="edu-checklist-item">
                                <i class="fas fa-check-circle" style="margin-top: 5px;"></i> 
                                <div><strong>18 - 24 Bulan:</strong> DPT-HB-Hib (Lanjutan), Campak/MR (Lanjutan)</div>
                            </div>
                        </div>
                    </div>

                    <div class="edu-tip-box">
                        <div class="edu-tip-icon"><i class="fas fa-lightbulb"></i></div>
                        <div>
                            <strong>Tips:</strong> Bawa buku KIA (Kesehatan Ibu dan Anak) setiap kali kunjungan ke Posyandu atau Puskesmas untuk memantau jadwal imunisasi dan pertumbuhan anak.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="edu-article-sidebar">
                <div class="edu-sidebar-card">
                    <h4><i class="fas fa-list"></i> Daftar Materi</h4>
                    <nav class="edu-sidebar-nav">
                        <a href="#asi-eksklusif"><i class="fas fa-heart"></i> ASI Eksklusif 6 Bulan</a>
                        <a href="#mpasi"><i class="fas fa-utensils"></i> MPASI Mulai 6 Bulan</a>
                        <a href="#jadwal-makan"><i class="fas fa-clock"></i> Jadwal & Porsi Makan</a>
                        <a href="#stimulasi"><i class="fas fa-puzzle-piece"></i> Stimulasi Tumbuh Kembang</a>
                        <a href="#imunisasi"><i class="fas fa-syringe"></i> Pentingnya Imunisasi</a>
                    </nav>
                </div>

                <div class="edu-sidebar-card edu-sidebar-card--accent">
                    <h4><i class="fas fa-calculator"></i> Hitung Gizi Anak</h4>
                    <p>Pastikan menu harian anak Anda sudah memenuhi kebutuhan nutrisi.</p>
                    <a href="/kalkulator" class="btn btn-primary btn-sm" style="width: 100%; justify-content: center;">Buka Kalkulator</a>
                </div>

                <div class="edu-sidebar-card">
                    <h4><i class="fas fa-book-open"></i> Modul Lainnya</h4>
                    <nav class="edu-sidebar-nav">
                        <a href="/edukasi/phbs"><i class="fas fa-hand-sparkles"></i> PHBS</a>
                        <a href="/edukasi/kehamilan"><i class="fas fa-person-pregnant"></i> Perawatan Kehamilan</a>
                        <a href="/stunting"><i class="fas fa-heart-pulse"></i> Cegah Stunting</a>
                    </nav>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection