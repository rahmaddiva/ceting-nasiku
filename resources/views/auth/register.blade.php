<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — CETING NASIKU</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
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
                <h2>Buat Akun Baru</h2>
                <p>Daftar untuk mengakses semua fitur</p>
            </div>

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="/register" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus>
                </div>
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan email" required>
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 8 karakter" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation"><i class="fas fa-lock"></i> Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    <i class="fas fa-user-plus"></i> Daftar
                </button>
            </form>

            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: var(--text-secondary);">
                Sudah punya akun? <a href="/login" style="color: var(--primary-600); font-weight: 600;">Masuk di sini</a>
            </p>
            <p style="text-align: center; margin-top: 0.5rem;">
                <a href="/" style="color: var(--text-muted); font-size: 0.85rem;"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
            </p>
        </div>
    </div>
</body>
</html>
