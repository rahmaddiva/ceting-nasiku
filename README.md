# CETING NASIKU

**Cegah Stunting Melalui Pemenuhan Gizi untuk Keluarga Unggul**

Aplikasi web berbasis Laravel untuk mendukung program pencegahan stunting di tingkat desa dan kelurahan.

---

## Tentang Program

Ceting Nasiku dilaksanakan oleh pemerintah desa/kelurahan melalui pengembangan kelompok atau kelembagaan lokal yang sesuai dengan potensi dan kebutuhan penanganan stunting yang ada di tingkat desa dan sekitarnya.

Pemerintah desa/kelurahan dalam melaksanakan Ceting Nasiku dibantu oleh kader penggerak dan motivator yang terdiri dari PKK, PPKBD/Sub-PPKBD, dan kader lainnya, termasuk tenaga kesehatan dan mahasiswa magang sebagai pendamping. Keberadaan Ceting Nasiku di Kampung KB juga tidak terlepas dari peran Pokja Kampung KB.

Sementara pemerintah, baik pemerintah pusat, provinsi dan kabupaten/kota selain berfungsi sebagai regulator dan fasilitator, juga berperan dalam melakukan edukasi, pendampingan dan pembinaan teknis melalui dinas terkait dan para petugasnya yang berada di tingkat desa.

---

## Tentang Aplikasi

Aplikasi ini hadir sebagai pendukung digital program Ceting Nasiku, memudahkan akses informasi gizi, resep makanan bergizi, dan konsultasi pencegahan stunting bagi masyarakat, kader, dan tenaga pendamping.

Fitur utama:

- **Resep Bergizi** — koleksi resep untuk bayi, balita, ibu hamil, dan ibu menyusui, lengkap dengan bahan lokal yang terjangkau
- **Edukasi Stunting** — materi pola asuh, PHBS, gizi seimbang, dan kesehatan kehamilan
- **Kalkulator Gizi** — hitung kebutuhan nutrisi harian berdasarkan usia dan kondisi
- **Cek Risiko Stunting** — skrining awal risiko stunting secara mandiri
- **Chatbot NASI** — asisten AI (Narasumber Ahli Stunting Indonesia) siap menjawab pertanyaan seputar gizi dan stunting 24 jam

---

## Tech Stack

- **Backend:** PHP 8.1+, Laravel 10
- **Admin Panel:** Blade custom (`/admin`)
- **Frontend:** Blade + Vite + CSS design system
- **AI Chatbot:** OpenAgentic API

---

## Setup Lokal

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
npm install && npm run dev
php artisan serve
```

Tambahkan `OPENAGENTIC_API_KEY=your_api_key` di `.env` untuk mengaktifkan chatbot NASI.

---

## Lisensi

MIT
