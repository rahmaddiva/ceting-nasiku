# AGENTS.md — Ceting Nasiku

Panduan untuk AI agent yang bekerja di repo ini.

## Tentang Proyek

**CETING NASIKU** (Cegah Stunting Melalui Pemenuhan Gizi untuk Keluarga Unggul) adalah aplikasi web Laravel untuk pencegahan stunting. Fitur utama:

- Resep makanan bergizi untuk bayi, balita, ibu hamil, dan ibu menyusui
- Edukasi stunting (gizi, pola asuh, PHBS, kehamilan)
- Kalkulator gizi
- Cek risiko stunting
- Chatbot **NASI** (Narasumber Ahli Stunting Indonesia) via Cartethyia API

## Tech Stack

- **Backend:** PHP 8.1+, Laravel 10
- **Admin panel:** Blade custom (`resources/views/admin/*`) — bukan Filament
- **Frontend:** Blade + Vite + `public/css/app.css`
- **HTTP client:** Guzzle (via `Http` facade)
- **Testing:** PHPUnit 10
- **Linting:** Laravel Pint

## Struktur Penting

```
app/
  Http/
    Controllers/
      Admin/              # CRUD: recipes, ingredients, categories + dashboard
      AuthController.php
      ChatbotController.php      # POST /chatbot/send → Cartethyia
      EducationController.php
      HomeController.php
      NutritionCalculatorController.php
      PublicRecipeController.php
      StuntingController.php
    Middleware/
      AdminMiddleware.php  # Guard untuk route /admin/*
  Models/
    Category.php
    Ingredient.php
    Recipe.php             # fields: title, slug, age_group, is_published, ...
    User.php               # field tambahan: role (via migration)
resources/views/admin/     # layout + dashboard + CRUD views
public/css/app.css         # design system + admin styles
database/migrations/       # semua skema ada di sini
routes/web.php             # semua route publik + admin
```

## Environment Variables

| Key | Keterangan |
|-----|------------|
| `CARTETHYIA_BASE_URL` | Base URL Cartethyia (default `https://carte.risun.web.id/v1`) |
| `CARTETHYIA_API_KEY` | API key Cartethyia untuk chatbot NASI |
| `CARTETHYIA_MODEL` | Model chatbot (default `bansos/deepseek-v4.1-flash`) |
| `CARTETHYIA_TIMEOUT` | Timeout request chatbot (detik) |
| `DB_*` | Koneksi database standar Laravel |
Jangan pernah commit nilai `.env`. Gunakan `.env.example` sebagai referensi.

## Setup Lokal

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
npm install && npm run dev
php artisan serve
```

## Perintah Berguna

```bash
php artisan migrate          # jalankan migrasi
php artisan migrate:fresh --seed  # reset DB + seed
php artisan pint             # format kode (PSR-12)
php artisan test             # jalankan test suite
APP_ENV=testing php vendor/phpunit/phpunit/phpunit   # dipakai di mesin ini (php artisan test bisa salah lapor 419 CSRF)
npm run build                # build asset produksi
```

## Konvensi Kode

- Ikuti PSR-12 — gunakan `php artisan pint` sebelum commit
- Route model binding untuk controller publik
- Admin route wajib pakai middleware `['auth', 'admin']`
- Slug recipe harus unik; generate dari title
- `is_published` menentukan visibilitas resep di frontend publik
- `age_group` isi dengan format: `6-8 bulan`, `1-3 tahun`, dst.

## Chatbot (ChatbotController)

- Endpoint: `POST /chatbot/send` (publik, tanpa auth)
- Provider: Cartethyia (OpenAI-compatible) — base URL `https://carte.risun.web.id/v1`
- Model: `bansos/deepseek-v4.1-flash` (diatur via `CARTETHYIA_MODEL`)
- Kirim `history` (array `{role, content}`) untuk percakapan multi-turn
- Jangan ubah system prompt tanpa diskusi — prompt menentukan persona NASI
- Proteksi prompt-injection: `history.*.role` dibatasi `user|assistant`; pesan pengguna dibungkus pembatas data; ada rate limit per IP
- Kredensial dibaca via `config('services.cartethyia.*')`, BUKAN `env()` langsung — agar aman saat `config:cache`

## Admin Panel

- Route: `/admin/*` dengan middleware `['auth', 'admin']`
- Layout: `resources/views/admin/layouts/app.blade.php`
- Dashboard: `AdminDashboardController` + `resources/views/admin/dashboard.blade.php`
- Styling admin di `public/css/app.css` (section ADMIN PANEL STYLES)
- Jangan re-introduce Filament — admin custom Blade sudah cukup

## Hal yang Tidak Boleh Dilakukan

- Jangan commit `.env` atau nilai secret apapun
- Jangan hapus middleware `admin` dari route `/admin/*`
- Jangan tambah dependency baru tanpa alasan jelas — cek dulu apakah Laravel sudah menyediakan
- Jangan ubah skema migration yang sudah ada; buat migration baru
- Jangan install Filament lagi tanpa permintaan eksplisit

## Testing

```bash
php artisan test
php artisan test --filter=NamaTes
```

Test ada di `tests/Feature/` dan `tests/Unit/`. Tambahkan feature test untuk setiap controller baru.
