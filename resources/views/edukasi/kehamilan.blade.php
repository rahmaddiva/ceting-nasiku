@extends('layouts.public')
@section('body_class', 'page-inner')
@section('title', 'Perawatan Kehamilan — Modul Edukasi — CETING NASIKU')
@section('meta_description', 'Panduan perawatan kehamilan: pemeriksaan ANC, nutrisi ibu hamil, tanda bahaya kehamilan, persiapan persalinan, dan 1000 hari pertama kehidupan.')
@section('og_title', 'Perawatan Kehamilan — Modul Edukasi — CETING NASIKU')
@section('og_description', 'Panduan perawatan kehamilan: pemeriksaan ANC, nutrisi ibu hamil, tanda bahaya kehamilan.')
@section('og_type', 'article')

@section('content')
<!-- Hero -->
<section class="edu-hero edu-hero--compact">
    <div class="edu-hero__bg">
        <img src="{{ asset('images/kehamilan.png') }}" alt="Ibu hamil melakukan pemeriksaan kehamilan">
        <div class="edu-hero__overlay"></div>
    </div>
    <div class="container" style="position: relative; z-index: 2;">
        <a href="/edukasi" class="edu-breadcrumb"><i class="fas fa-arrow-left"></i> Kembali ke Modul Edukasi</a>
        <div class="section-badge section-badge-hero">
            <i class="fas fa-person-pregnant"></i> Modul Edukasi
        </div>
        <h1>Perawatan <span>Kehamilan</span></h1>
        <p>Panduan perawatan kehamilan yang tepat untuk menjaga kesehatan ibu dan janin serta mencegah stunting sejak dalam kandungan.</p>
    </div>
</section>

<!-- Content -->
<div class="edu-article">
    <div class="container">
        <div class="edu-article-layout">
            <!-- Main Content -->
            <div class="edu-article-main">

                <!-- Section 1: ANC -->
                <div class="edu-article-section" id="pemeriksaan-anc">
                    <div class="edu-article-section-num">01</div>
                    <h2><i class="fas fa-stethoscope" style="color: var(--info);"></i> Pemeriksaan Kehamilan (ANC Terpadu)</h2>
                    <p>Antenatal Care (ANC) adalah pemeriksaan kehamilan rutin yang dilakukan untuk memantau kesehatan ibu dan perkembangan janin. Pemeriksaan ini sangat penting untuk mencegah komplikasi dan memastikan janin tumbuh optimal tanpa risiko stunting.</p>
                    <div class="edu-highlight-box" style="border-left-color: var(--info); margin-bottom: 2rem;">
                        <h4><i class="fas fa-calendar-check"></i> Jadwal Pemeriksaan ANC (Minimal 6x)</h4>
                        <div class="edu-checklist" style="margin-bottom: 1rem;">
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> <strong>Trimester 1 (0-12 minggu):</strong> Minimal 1 kali kunjungan (wajib dengan dokter)</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> <strong>Trimester 2 (13-27 minggu):</strong> Minimal 2 kali kunjungan</div>
                            <div class="edu-checklist-item"><i class="fas fa-check-circle"></i> <strong>Trimester 3 (28-40 minggu):</strong> Minimal 3 kali kunjungan (1x wajib dengan dokter)</div>
                        </div>
                    </div>

                    <div class="edu-highlight-box" style="border-left-color: var(--primary-500); background: var(--primary-50);">
                        <h4 style="color: var(--primary-700);"><i class="fas fa-list-check"></i> Standar Pelayanan Pemeriksaan 12T</h4>
                        <p style="font-size: 0.9rem; margin-bottom: 1rem;">Setiap ibu hamil berhak mendapatkan pelayanan standar "12T" saat kontrol kehamilan di fasilitas kesehatan:</p>
                        <div class="edu-grid-2col" style="gap: 1rem;">
                            <div class="edu-checklist" style="font-size: 0.85rem;">
                                <div class="edu-checklist-item"><i class="fas fa-ruler-vertical" style="color: var(--primary-500);"></i> <strong>1. Timbang berat badan dan ukur tinggi badan</strong></div>
                                <div class="edu-checklist-item"><i class="fas fa-heart-pulse" style="color: var(--primary-500);"></i> <strong>2. Tekanan darah diukur</strong></div>
                                <div class="edu-checklist-item"><i class="fas fa-ruler-combined" style="color: var(--primary-500);"></i> <strong>3. Tentukan status gizi (ukur LILA - Lingkar Lengan Atas)</strong></div>
                                <div class="edu-checklist-item"><i class="fas fa-ruler" style="color: var(--primary-500);"></i> <strong>4. Tinggi fundus uteri (puncak rahim) diukur</strong></div>
                                <div class="edu-checklist-item"><i class="fas fa-stethoscope" style="color: var(--primary-500);"></i> <strong>5. Tentukan presentasi janin dan denyut jantung janin</strong></div>
                                <div class="edu-checklist-item"><i class="fas fa-syringe" style="color: var(--primary-500);"></i> <strong>6. TT (Tetanus Toxoid) skrining status imunisasi</strong></div>
                            </div>
                            <div class="edu-checklist" style="font-size: 0.85rem;">
                                <div class="edu-checklist-item"><i class="fas fa-pills" style="color: var(--primary-500);"></i> <strong>7. Tablet tambah darah (Fe) minimal 90 butir</strong></div>
                                <div class="edu-checklist-item"><i class="fas fa-vial" style="color: var(--primary-500);"></i> <strong>8. Tes laboratorium rurin (Hemoglobin, Golongan Darah, Protein Urin)</strong></div>
                                <div class="edu-checklist-item"><i class="fas fa-comments" style="color: var(--primary-500);"></i> <strong>9. Tata laksana kasus / penanganan jika ada komplikasi</strong></div>
                                <div class="edu-checklist-item"><i class="fas fa-users" style="color: var(--primary-500);"></i> <strong>10. Temu wicara (konseling)</strong></div>
                                <div class="edu-checklist-item"><i class="fas fa-hand-holding-medical" style="color: var(--primary-500);"></i> <strong>11. Terapi pencegahan Malaria (khusus daerah endemis)</strong></div>
                                <div class="edu-checklist-item"><i class="fas fa-virus" style="color: var(--primary-500);"></i> <strong>12. Tes VCT (Voluntary Counseling and Testing) untuk HIV, Sifilis & Hepatitis B</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="edu-tip-box" style="margin-top: 1.5rem;">
                        <div class="edu-tip-icon"><i class="fas fa-lightbulb"></i></div>
                        <div>
                            <strong>Tips:</strong> Pastikan Anda mendapatkan layanan 12T tersebut. Selalu bawa buku KIA (Kesehatan Ibu dan Anak) setiap kali periksa ke Bidan, Puskesmas, atau Dokter Kandungan.
                        </div>
                    </div>
                </div>

                <!-- Section 2: Nutrisi Ibu Hamil -->
                <div class="edu-article-section" id="nutrisi-bumil">
                    <div class="edu-article-section-num">02</div>
                    <h2><i class="fas fa-apple-whole" style="color: var(--primary-600);"></i> Nutrisi Ibu Hamil</h2>
                    <p>Gizi yang baik selama kehamilan sangat menentukan pertumbuhan dan perkembangan janin. Kekurangan gizi pada ibu hamil adalah salah satu penyebab utama stunting pada anak.</p>

                    <div class="edu-grid-2col">
                        <div class="edu-mini-card">
                            <div class="edu-mini-card-icon"><i class="fas fa-drumstick-bite"></i></div>
                            <h4>Protein Tinggi</h4>
                            <p>Konsumsi telur, ikan, daging, tahu, tempe setiap hari. Protein penting untuk pembentukan organ dan jaringan janin.</p>
                        </div>
                        <div class="edu-mini-card">
                            <div class="edu-mini-card-icon" style="background: #fef2f2; color: var(--danger);"><i class="fas fa-pills"></i></div>
                            <h4>Tablet Tambah Darah (Fe)</h4>
                            <p>Minum 1 tablet Fe setiap hari selama kehamilan (minimal 90 tablet) untuk mencegah anemia yang berbahaya bagi ibu dan janin.</p>
                        </div>
                        <div class="edu-mini-card">
                            <div class="edu-mini-card-icon" style="background: var(--accent-50); color: var(--accent-600);"><i class="fas fa-leaf"></i></div>
                            <h4>Asam Folat</h4>
                            <p>Konsumsi sayuran hijau, kacang-kacangan, dan suplemen asam folat terutama di trimester pertama untuk mencegah cacat tabung saraf.</p>
                        </div>
                        <div class="edu-mini-card">
                            <div class="edu-mini-card-icon" style="background: var(--primary-50); color: var(--info);"><i class="fas fa-bone"></i></div>
                            <h4>Kalsium</h4>
                            <p>Susu, ikan teri, brokoli, dan tahu kaya kalsium yang dibutuhkan untuk pembentukan tulang dan gigi janin.</p>
                        </div>
                    </div>

                    <div class="edu-table-responsive">
                        <table class="edu-table">
                            <thead>
                                <tr>
                                    <th>Nutrisi</th>
                                    <th>Kebutuhan/Hari</th>
                                    <th>Sumber Makanan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Kalori</strong></td>
                                    <td>+300 kkal (trimester 2-3)</td>
                                    <td>Nasi, roti, ubi, jagung</td>
                                </tr>
                                <tr>
                                    <td><strong>Protein</strong></td>
                                    <td>+20 gram</td>
                                    <td>Telur, ikan, daging, tempe</td>
                                </tr>
                                <tr>
                                    <td><strong>Zat Besi</strong></td>
                                    <td>27 mg</td>
                                    <td>Hati, daging merah, bayam</td>
                                </tr>
                                <tr>
                                    <td><strong>Asam Folat</strong></td>
                                    <td>600 mcg</td>
                                    <td>Sayuran hijau, kacang-kacangan</td>
                                </tr>
                                <tr>
                                    <td><strong>Kalsium</strong></td>
                                    <td>1200 mg</td>
                                    <td>Susu, ikan teri, brokoli</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 3: Tanda Bahaya -->
                <div class="edu-article-section" id="tanda-bahaya">
                    <div class="edu-article-section-num">03</div>
                    <h2><i class="fas fa-triangle-exclamation" style="color: var(--danger);"></i> Tanda Bahaya Kehamilan</h2>
                    <p>Kenali tanda-tanda bahaya selama kehamilan. Jika mengalami salah satu gejala di bawah ini, <strong>segera kunjungi fasilitas kesehatan terdekat</strong>.</p>

                    <div class="edu-warning-box" style="background: #fef2f2; border-left: 4px solid var(--danger);">
                        <div class="edu-tip-icon" style="background: #fee2e2; color: var(--danger);"><i class="fas fa-exclamation-triangle"></i></div>
                        <div>
                            <strong>Segera ke Faskes jika mengalami:</strong>
                        </div>
                    </div>

                    <div class="edu-grid-2col" style="margin-top: 1.5rem;">
                        <div class="edu-mini-card" style="border-left: 3px solid var(--danger);">
                            <div class="edu-mini-card-icon" style="background: #fef2f2; color: var(--danger);"><i class="fas fa-droplet"></i></div>
                            <h4>Perdarahan</h4>
                            <p>Perdarahan dari jalan lahir pada usia kehamilan berapa pun merupakan tanda bahaya yang harus segera ditangani.</p>
                        </div>
                        <div class="edu-mini-card" style="border-left: 3px solid var(--danger);">
                            <div class="edu-mini-card-icon" style="background: #fef2f2; color: var(--danger);"><i class="fas fa-head-side-cough"></i></div>
                            <h4>Sakit Kepala Hebat</h4>
                            <p>Sakit kepala yang tak tertahankan, pandangan kabur, dan bengkak pada wajah/tangan bisa menandakan pre-eklampsia.</p>
                        </div>
                        <div class="edu-mini-card" style="border-left: 3px solid var(--danger);">
                            <div class="edu-mini-card-icon" style="background: #fef2f2; color: var(--danger);"><i class="fas fa-temperature-high"></i></div>
                            <h4>Demam Tinggi</h4>
                            <p>Demam tinggi disertai kejang bisa membahayakan ibu dan janin. Segera cari pertolongan medis.</p>
                        </div>
                        <div class="edu-mini-card" style="border-left: 3px solid var(--danger);">
                            <div class="edu-mini-card-icon" style="background: #fef2f2; color: var(--danger);"><i class="fas fa-baby"></i></div>
                            <h4>Gerakan Janin Berkurang</h4>
                            <p>Jika janin tidak bergerak seperti biasa (kurang dari 10 gerakan dalam 12 jam), segera periksakan ke bidan/dokter.</p>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Persiapan Persalinan -->
                <div class="edu-article-section" id="persiapan-persalinan">
                    <div class="edu-article-section-num">04</div>
                    <h2><i class="fas fa-clipboard-list" style="color: var(--accent-700);"></i> Persiapan Persalinan</h2>
                    <p>Persiapan persalinan yang matang membantu memastikan proses kelahiran yang aman bagi ibu dan bayi.</p>

                    <div class="edu-timeline">
                        <div class="edu-timeline-item">
                            <div class="edu-timeline-marker"><i class="fas fa-user-doctor" style="font-size: 0.7rem;"></i></div>
                            <div class="edu-timeline-content">
                                <h4>Tentukan Penolong Persalinan</h4>
                                <p>Pilih bidan atau dokter yang akan menolong persalinan. Pastikan tenaga kesehatan terlatih dan fasilitas memadai.</p>
                            </div>
                        </div>
                        <div class="edu-timeline-item">
                            <div class="edu-timeline-marker"><i class="fas fa-hospital" style="font-size: 0.7rem;"></i></div>
                            <div class="edu-timeline-content">
                                <h4>Tentukan Tempat Bersalin</h4>
                                <p>Rencanakan tempat persalinan — Puskesmas, rumah sakit, atau klinik. Pastikan mudah dijangkau dan memiliki fasilitas lengkap.</p>
                            </div>
                        </div>
                        <div class="edu-timeline-item">
                            <div class="edu-timeline-marker"><i class="fas fa-car" style="font-size: 0.7rem;"></i></div>
                            <div class="edu-timeline-content">
                                <h4>Siapkan Transportasi</h4>
                                <p>Siapkan kendaraan dan pengantar. Catat nomor telepon ambulans desa dan keluarga yang bisa membantu sewaktu-waktu.</p>
                            </div>
                        </div>
                        <div class="edu-timeline-item">
                            <div class="edu-timeline-marker"><i class="fas fa-wallet" style="font-size: 0.7rem;"></i></div>
                            <div class="edu-timeline-content">
                                <h4>Siapkan Dana</h4>
                                <p>Tabung biaya persalinan dari awal kehamilan. Daftarkan BPJS Kesehatan untuk jaminan persalinan tanpa biaya tambahan.</p>
                            </div>
                        </div>
                        <div class="edu-timeline-item">
                            <div class="edu-timeline-marker"><i class="fas fa-suitcase" style="font-size: 0.7rem;"></i></div>
                            <div class="edu-timeline-content">
                                <h4>Siapkan Perlengkapan</h4>
                                <p>Kemas baju ibu dan bayi, perlengkapan mandi, dokumen (KTP, buku KIA, kartu BPJS), dan kebutuhan lainnya.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 5: 1000 HPK -->
                <div class="edu-article-section" id="1000-hpk">
                    <div class="edu-article-section-num">05</div>
                    <h2><i class="fas fa-star" style="color: var(--accent-600);"></i> 1000 Hari Pertama Kehidupan</h2>
                    <p>Periode 1000 Hari Pertama Kehidupan (HPK) dimulai dari masa kehamilan (270 hari) hingga anak berusia 2 tahun (730 hari). Ini adalah <strong>periode emas</strong> yang menentukan kualitas kesehatan anak di masa depan.</p>

                    <div class="edu-highlight-box" style="border-left-color: var(--accent-500); background: var(--accent-50);">
                        <h4 style="color: var(--accent-700);"><i class="fas fa-timeline"></i> Tahapan 1000 HPK</h4>
                        <div class="edu-checklist">
                            <div class="edu-checklist-item" style="color: var(--accent-700);"><i class="fas fa-check-circle" style="color: var(--accent-500);"></i> <strong>Hari 1-270 (Kehamilan):</strong> Nutrisi ibu hamil, pemeriksaan rutin, tablet Fe, istirahat cukup</div>
                            <div class="edu-checklist-item" style="color: var(--accent-700);"><i class="fas fa-check-circle" style="color: var(--accent-500);"></i> <strong>Hari 271-450 (0-6 bulan):</strong> ASI eksklusif, IMD, imunisasi dasar, bonding ibu-bayi</div>
                            <div class="edu-checklist-item" style="color: var(--accent-700);"><i class="fas fa-check-circle" style="color: var(--accent-500);"></i> <strong>Hari 451-730 (6-12 bulan):</strong> MPASI bergizi, ASI lanjutan, stimulasi tumbuh kembang</div>
                            <div class="edu-checklist-item" style="color: var(--accent-700);"><i class="fas fa-check-circle" style="color: var(--accent-500);"></i> <strong>Hari 731-1000 (12-24 bulan):</strong> Makanan keluarga, imunisasi lanjutan, pemantauan pertumbuhan</div>
                        </div>
                    </div>

                    <div class="edu-tip-box">
                        <div class="edu-tip-icon"><i class="fas fa-lightbulb"></i></div>
                        <div>
                            <strong>Ingat:</strong> Stunting yang terjadi di periode 1000 HPK bersifat permanen dan sulit diperbaiki setelahnya. Intervensi gizi dan kesehatan di periode ini sangat krusial untuk masa depan anak.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="edu-article-sidebar">
                <div class="edu-sidebar-card">
                    <h4><i class="fas fa-list"></i> Daftar Materi</h4>
                    <nav class="edu-sidebar-nav">
                        <a href="#pemeriksaan-anc"><i class="fas fa-stethoscope"></i> Pemeriksaan ANC</a>
                        <a href="#nutrisi-bumil"><i class="fas fa-apple-whole"></i> Nutrisi Ibu Hamil</a>
                        <a href="#tanda-bahaya"><i class="fas fa-triangle-exclamation"></i> Tanda Bahaya</a>
                        <a href="#persiapan-persalinan"><i class="fas fa-clipboard-list"></i> Persiapan Persalinan</a>
                        <a href="#1000-hpk"><i class="fas fa-star"></i> 1000 Hari Pertama</a>
                    </nav>
                </div>

                <div class="edu-sidebar-card edu-sidebar-card--accent">
                    <h4><i class="fas fa-calculator"></i> Hitung Gizi</h4>
                    <p>Pastikan kebutuhan nutrisi harian Anda dan bayi tercukupi.</p>
                    <a href="/kalkulator" class="btn btn-primary btn-sm" style="width: 100%; justify-content: center;">Buka Kalkulator</a>
                </div>

                <div class="edu-sidebar-card">
                    <h4><i class="fas fa-book-open"></i> Modul Lainnya</h4>
                    <nav class="edu-sidebar-nav">
                        <a href="/edukasi/pola-asuh"><i class="fas fa-baby"></i> Pola Asuh Anak</a>
                        <a href="/edukasi/phbs"><i class="fas fa-hand-sparkles"></i> PHBS</a>
                        <a href="/stunting"><i class="fas fa-heart-pulse"></i> Cegah Stunting</a>
                    </nav>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
