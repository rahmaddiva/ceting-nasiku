<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — CETING NASIKU</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&family=Noto+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="auth-page">
        <div class="auth-card">
            <div class="brand-header">
                <div class="brand-icon">
                    <i class="fas fa-seedling"></i>
                </div>
                <h2>Selamat Datang</h2>
                <p>Masuk ke akun CETING NASIKU Anda</p>
            </div>

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="/login" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan email Anda" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember" style="margin-bottom:0; font-weight:400; font-size:0.85rem;">Ingat saya</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>
            </form>

            <p style="text-align: center; margin-top: 1.5rem;">
                Belum punya akun? <a href="/register" style="color: var(--primary-600); font-weight: 600;">Daftar</a>
                &nbsp;•&nbsp;
                <a href="/" style="color: var(--text-muted); font-size: 0.85rem;"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
            </p>
        </div>
    </div>
</body>
</html>
