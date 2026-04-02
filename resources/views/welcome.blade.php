<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang - Pengaduan Prasarana Sekolah</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        body {
            background-color: var(--background);
            color: var(--text);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background-image:
                radial-gradient(at 0% 0%, rgba(15, 23, 42, 0.03) 0, transparent 50%),
                radial-gradient(at 100% 100%, rgba(148, 114, 60, 0.03) 0, transparent 50%);
        }

        .hero {
            text-align: center;
            max-width: 600px;
            padding: 2rem;
            animation: fadeIn 1s ease-out;
        }

        .logo-large {
            height: 140px;
            margin-bottom: 2rem;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.05));
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        p {
            font-size: 1.125rem;
            color: var(--text-muted);
            margin-bottom: 3rem;
            line-height: 1.6;
        }

        .cta-group {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
        }

        .btn-large {
            padding: 1rem 2.5rem;
            font-size: 1rem;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-classic {
            background: var(--primary);
            color: white;
            border: 1px solid var(--primary);
        }

        .btn-primary-classic:hover {
            background: var(--accent);
            border-color: var(--accent);
            transform: translateY(-2px);
            box-shadow: var(--shadow-classic);
        }

        .btn-outline-classic {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--border);
        }

        .btn-outline-classic:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        footer {
            margin-top: 3rem;
            font-size: 0.875rem;
            color: var(--text-muted);
        }
    </style>
</head>

<body>
    <div class="hero">
        <img src="{{ asset('images/logo-student.png') }}" alt="Logo" class="logo-large">
        <h1>Pengaduan Prasarana Sekolah</h1>
        <p>Layanan aduan kerusakan sarana prasarana sekolah yang aman, cepat, dan transparan. Laporkan kendala demi
            kenyamanan belajar bersama.</p>

        <div class="cta-group">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-large btn-primary-classic">Masuk ke Dasbor</a>
            @else
                <a href="{{ route('login') }}" class="btn-large btn-primary-classic">Masuk</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-large btn-outline-classic">Daftar Akun</a>
                @endif
            @endauth
        </div>

        <footer style="margin-top: 2rem;">
            &copy; {{ date('Y') }} Pengaduan Prasarana Sekolah. Dibuat dengan integritas.
        </footer>
    </div>
</body>

</html>