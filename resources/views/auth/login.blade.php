<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Pengaduan Prasarana Sekolah</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
</head>

<body class="auth-wrapper">
    <div class="card auth-card shadow-lg">
        <div style="text-align: center; margin-bottom: 3rem;">
            <img src="{{ asset('images/logo-student.png') }}" alt="Logo" class="auth-logo"
                style="height: 100px; margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.75rem; color: var(--primary); font-family: 'Playfair Display', serif;">PENGADUAN
                PRASARANA SEKOLAH</h1>
            <p
                style="color: var(--accent); font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.75rem;">
                Lapor Kendala, Wujudkan Kenyamanan</p>
        </div>

        @if(session('success'))
            <div style="background:#D1FAE5; color:#065F46; padding: 0.75rem; border-radius: 8px; margin-bottom: 1rem;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background:#FEE2E2; color:#991B1B; padding: 0.75rem; border-radius: 8px; margin-bottom: 1rem;">
                Username atau password salah.
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="username"><i class="bi bi-person"></i> Username</label>
                <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}"
                    required autofocus placeholder="Masukkan username Anda">
            </div>

            <div class="form-group">
                <label class="form-label" for="password"><i class="bi bi-shield-lock"></i> Kata Sandi</label>
                <input type="password" id="password" name="password" class="form-control" required
                    placeholder="Masukkan kata sandi">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">Masuk Sekarang</button>

            <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted); font-size: 0.875rem;">
                Belum punya akun? <a href="{{ route('register') }}" style="font-weight: 600;">Daftar di sini</a>
            </p>
        </form>
    </div>
</body>

</html>