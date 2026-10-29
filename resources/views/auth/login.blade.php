<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — CETING NASIKU</title>
    <meta name="description" content="Masuk ke akun CETING NASIKU untuk memantau tumbuh kembang anak dan mengakses resep bergizi.">
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
                    Pantau tumbuh kembang anak,<br>
                    cegah stunting sejak dini.
                </h1>
                <p class="auth-visual-sub">
                    Catat berat dan tinggi badan, lihat status gizi menurut standar WHO,
                    dan temukan resep bergizi sesuai usia anak.
                </p>

                <ul class="auth-visual-list">
                    <li><i class="fas fa-chart-line" aria-hidden="true"></i> Grafik pertumbuhan &amp; z-score WHO</li>
                    <li><i class="fas fa-utensils" aria-hidden="true"></i> 105+ resep bergizi sesuai usia</li>
                    <li><i class="fas fa-user-shield" aria-hidden="true"></i> Data anak tersimpan di akun Anda</li>
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
                    <h2>Masuk ke akun Anda</h2>
                    <p>Belum punya akun? <a href="/register">Daftar gratis</a></p>
                </header>

                @if ($errors->any())
                <div class="auth-error-summary" id="auth-error-summary" role="alert" tabindex="-1" aria-labelledby="auth-error-title">
                    <h3 id="auth-error-title"><i class="fas fa-circle-exclamation" aria-hidden="true"></i> Ada masalah saat masuk</h3>
                    <ul>
                        @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="/login" method="POST" class="auth-form">
                    @csrf

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
                                autocomplete="username"
                                inputmode="email"
                                required
                                autofocus
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
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required
                                @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
                            <button type="button" class="field-action" id="togglePassword"
                                    aria-label="Tampilkan password" aria-pressed="false" aria-controls="password">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                        @error('password')
                        <p class="form-error" id="password-error"><i class="fas fa-circle-exclamation" aria-hidden="true"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-form-row">
                        <label class="form-check" for="remember">
                            <input type="checkbox" name="remember" id="remember" @checked(old('remember'))>
                            <span>Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-accent auth-submit" id="loginSubmit">
                        <i class="fas fa-right-to-bracket" aria-hidden="true"></i>
                        <span class="auth-submit-label">Masuk</span>
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
            // Tampilkan/sembunyikan password
            var toggle = document.getElementById('togglePassword');
            var pass = document.getElementById('password');
            if (toggle && pass) {
                toggle.addEventListener('click', function () {
                    var show = pass.type === 'password';
                    pass.type = show ? 'text' : 'password';
                    toggle.setAttribute('aria-pressed', String(show));
                    toggle.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
                    toggle.querySelector('i').className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
                });
            }

            // Status pengiriman form
            var form = document.querySelector('.auth-form');
            var submit = document.getElementById('loginSubmit');
            if (form && submit) {
                form.addEventListener('submit', function () {
                    // Event submit hanya terpicu setelah validasi HTML5 lolos.
                    submit.disabled = true;
                    submit.classList.add('is-loading');
                    submit.querySelector('.auth-submit-label').textContent = 'Memproses…';
                    submit.querySelector('i').className = 'fas fa-spinner fa-spin';
                });
            }

            // Fokuskan ringkasan error agar pembaca layar langsung tahu
            var summary = document.getElementById('auth-error-summary');
            if (summary) summary.focus();
        })();
    </script>
</body>
</html>
