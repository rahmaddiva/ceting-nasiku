<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — CETING NASIKU</title>
    <meta name="description" content="Buat akun CETING NASIKU gratis untuk memantau tumbuh kembang anak dan menyimpan resep bergizi.">
    <meta name="robots" content="noindex, follow">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <meta name="theme-color" content="#047857">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&family=Noto+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) ?: '1' }}">
</head>
<body class="auth-body">
    <div class="auth-split">
        <!-- Panel brand -->
        <aside class="auth-visual">
            <div class="auth-visual-inner">
                <a href="/" class="auth-visual-brand">
                    <img src="{{ asset('images/ceting_nasiku-mark.png') }}" alt="" width="44" height="44">
                    <span>CETING NASIKU</span>
                </a>

                <h1 class="auth-visual-title">
                    Satu akun untuk gizi<br>
                    dan tumbuh kembang anak.
                </h1>
                <p class="auth-visual-sub">
                    Simpan profil anak, catat pengukuran tiap bulan, dan lihat status gizinya
                    dibandingkan standar WHO — semuanya dalam satu tempat.
                </p>

                <ul class="auth-visual-list">
                    <li><i class="fas fa-child-reaching" aria-hidden="true"></i> Profil &amp; riwayat pengukuran anak</li>
                    <li><i class="fas fa-chart-line" aria-hidden="true"></i> Status gizi otomatis (z-score WHO)</li>
                    <li><i class="fas fa-unlock-keyhole" aria-hidden="true"></i> Gratis, tanpa biaya</li>
                </ul>

                <p class="auth-visual-foot">Dinas P3AP2KB Kabupaten Tanah Laut</p>
            </div>
        </aside>

        <!-- Form -->
        <main class="auth-form-wrap">
            <div class="auth-form-card">
                <header class="auth-form-head">
                    <a href="/" class="auth-mark" aria-label="CETING NASIKU — beranda">
                        <img src="{{ asset('images/ceting_nasiku-mark.png') }}" alt="CETING NASIKU" width="48" height="48">
                    </a>
                    <h2>Buat akun baru</h2>
                    <p>Sudah punya akun? <a href="/login">Masuk</a></p>
                </header>

                @if ($errors->any())
                <div class="auth-error-summary" id="auth-error-summary" role="alert" tabindex="-1" aria-labelledby="auth-error-title">
                    <h3 id="auth-error-title"><i class="fas fa-circle-exclamation" aria-hidden="true"></i> Ada masalah saat mendaftar</h3>
                    <ul>
                        @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="/register" method="POST" class="auth-form">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nama lengkap</label>
                        <div class="field">
                            <i class="fas fa-user field-icon" aria-hidden="true"></i>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control has-icon @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Nama Anda"
                                autocomplete="name"
                                required
                                autofocus
                                @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
                        </div>
                        @error('name')
                        <p class="form-error" id="name-error"><i class="fas fa-circle-exclamation" aria-hidden="true"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="field">
                            <i class="fas fa-envelope field-icon" aria-hidden="true"></i>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control has-icon @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                autocomplete="email"
                                inputmode="email"
                                required
                                @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                        </div>
                        @error('email')
                        <p class="form-error" id="email-error"><i class="fas fa-circle-exclamation" aria-hidden="true"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="field">
                            <i class="fas fa-lock field-icon" aria-hidden="true"></i>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control has-icon has-action @error('password') is-invalid @enderror"
                                placeholder="Minimal 8 karakter"
                                autocomplete="new-password"
                                minlength="8"
                                aria-describedby="password-hint @error('password') password-error @enderror"
                                required
                                @error('password') aria-invalid="true" @enderror>
                            <button type="button" class="field-action" data-reveal="password"
                                    aria-label="Tampilkan password" aria-pressed="false" aria-controls="password">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                        <p class="auth-hint" id="password-hint">Gunakan minimal 8 karakter.</p>
                        @error('password')
                        <p class="form-error" id="password-error"><i class="fas fa-circle-exclamation" aria-hidden="true"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Ulangi password</label>
                        <div class="field">
                            <i class="fas fa-lock field-icon" aria-hidden="true"></i>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control has-icon has-action"
                                placeholder="Ulangi password"
                                autocomplete="new-password"
                                aria-describedby="password-match"
                                required>
                            <button type="button" class="field-action" data-reveal="password_confirmation"
                                    aria-label="Tampilkan ulangi password" aria-pressed="false" aria-controls="password_confirmation">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                        <p class="field-status" id="password-match" role="status" aria-live="polite"></p>
                    </div>

                    <button type="submit" class="btn btn-accent auth-submit" id="registerSubmit">
                        <i class="fas fa-user-plus" aria-hidden="true"></i>
                        <span class="auth-submit-label">Daftar</span>
                    </button>
                </form>

                <a href="/" class="auth-back">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i> Kembali ke beranda
                </a>
            </div>
        </main>
    </div>

    <script>
        (function () {
            // Tampilkan/sembunyikan password (berlaku untuk semua field dengan data-reveal)
            document.querySelectorAll('[data-reveal]').forEach(function (btn) {
                var input = document.getElementById(btn.dataset.reveal);
                if (!input) return;
                btn.addEventListener('click', function () {
                    var show = input.type === 'password';
                    input.type = show ? 'text' : 'password';
                    btn.setAttribute('aria-pressed', String(show));
                    btn.setAttribute('aria-label', (show ? 'Sembunyikan ' : 'Tampilkan ') + input.name.replace('_', ' '));
                    btn.querySelector('i').className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
                });
            });

            // Cocokkan password saat diketik
            var pass = document.getElementById('password');
            var confirm = document.getElementById('password_confirmation');
            var status = document.getElementById('password-match');

            function checkMatch() {
                if (!status) return;
                if (!confirm.value) {
                    status.textContent = '';
                    status.classList.remove('is-ok', 'is-bad');
                    confirm.removeAttribute('aria-invalid');
                    return;
                }
                var match = pass.value === confirm.value;
                status.textContent = match ? 'Password cocok.' : 'Password belum sama.';
                status.classList.toggle('is-ok', match);
                status.classList.toggle('is-bad', !match);
                confirm.setAttribute('aria-invalid', match ? 'false' : 'true');
            }

            if (pass && confirm) {
                confirm.addEventListener('input', checkMatch);
                pass.addEventListener('input', checkMatch);
            }

            // Status pengiriman form
            var form = document.querySelector('.auth-form');
            var submit = document.getElementById('registerSubmit');
            if (form && submit) {
                form.addEventListener('submit', function (e) {
                    if (pass && confirm && pass.value !== confirm.value) {
                        e.preventDefault();
                        checkMatch();
                        confirm.focus();
                        return;
                    }
                    submit.disabled = true;
                    submit.classList.add('is-loading');
                    submit.querySelector('.auth-submit-label').textContent = 'Memproses…';
                    submit.querySelector('i').className = 'fas fa-spinner fa-spin';
                });
            }

            var summary = document.getElementById('auth-error-summary');
            if (summary) summary.focus();
        })();
    </script>
</body>
</html>
