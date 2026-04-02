<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pengaduan Prasarana Sekolah')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
</head>
<body>
    @if(Auth::check())
    <nav class="navbar">
        <div class="logo-container">
            <div class="brand">PENGADUAN PRASARANA SEKOLAH</div>
        </div>
        <div class="nav-items">
            <span style="font-weight: 600; color: var(--text);">Halo, {{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
            <button type="submit" class="btn btn-outline" style="padding: 0.5rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </button>
            </form>
        </div>
    </nav>
    @endif

    <div class="container">
        @if(session('success'))
        <div class="card glass" style="background:#D1FAE5; color:#065F46; padding: 1rem; margin-bottom: 1.5rem; border-left: 4px solid #10B981;">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="card glass" style="background:#FEE2E2; color:#991B1B; padding: 1rem; margin-bottom: 1.5rem; border-left: 4px solid #EF4444;">
            {{ session('error') }}
        </div>
        @endif
        
        @if ($errors->any())
        <div class="card glass" style="background:#FEE2E2; color:#991B1B; padding: 1rem; margin-bottom: 1.5rem; border-left: 4px solid #EF4444;">
            <ul style="margin-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
