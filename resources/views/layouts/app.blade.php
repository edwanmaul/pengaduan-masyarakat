<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title','Pengaduan Masyarakat')</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@php($hasVite = file_exists(public_path('build/manifest.json')))
        @if ($hasVite)
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @endif
</head>
<body>
    <header class="topbar">
        <div class="container flex">
            <a href="{{ route('dashboard') }}" class="brand">Pengaduan</a>
            <nav class="nav">
                @auth
                    <span>{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="btn btn-light">Logout</button>
                    </form>
                @endauth
            </nav>
        </div>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">© {{ date('Y') }} Pengaduan Masyarakat</div>
    </footer>
</body>
</html>
