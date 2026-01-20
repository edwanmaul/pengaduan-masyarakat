<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>

    {{-- FONT INTER --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
</head>

<body class="bg-[#F5F5F5] font-[Inter]">

    <div class="min-h-screen flex items-center justify-center py-10 px-6">

        {{-- CARD WRAPPER --}}
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl p-10 flex flex-col items-center">

            {{-- LOGO --}}
            <img src="{{ asset('images/logo.png') }}"
                alt="Logo"
                class="w-56 mb-8">

            {{-- TITLE --}}
            <h1 class="text-center text-xl font-bold text-black leading-relaxed mb-6">
                Selamat Datang Di Tempat <br>
                Pengaduan Masyarakat
            </h1>

            {{-- BUTTON UNTUK YANG BELUM LOGIN --}}
@guest
    <a href="{{ route('register') }}"
        class="w-full bg-[#043915] text-white font-semibold py-3 rounded-lg text-center mt-10">
        Daftar
    </a>

    <a href="{{ route('login') }}"
        class="w-full bg-[#043915] text-white font-semibold py-3 rounded-lg text-center mt-4">
        Sudah Punya Akun?
    </a>
@endguest

            {{-- BUTTON UNTUK YANG SUDAH LOGIN --}}
@auth
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}"
            class="w-full bg-[#043915] text-white font-semibold py-3 rounded-lg text-center mt-10">
            Pergi ke Dashboard Admin
        </a>
    @else
        <a href="{{ route('user.dashboard') }}"
            class="w-full bg-[#043915] text-white font-semibold py-3 rounded-lg text-center mt-10">
            Pergi ke Dashboard
        </a>
    @endif
@endauth

    </div>

</body>
</html>
