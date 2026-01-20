<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="bg-[#F5F5F5] font-[Inter]">

    {{-- HEADER --}}
    <header class="bg-[#043915] py-4 px-4 flex items-center gap-3">
        <a href="{{ route('user.dashboard') }}" class="p-1">
            <img src="{{ asset('images/left-arrow-white.png') }}" alt="Kembali" class="w-6 h-6">
        </a>
        <h1 class="text-white text-xl font-bold">
            Ringkasan
        </h1>
    </header>

    <main class="px-4 py-6 space-y-4 max-w-xl mx-auto">

        <section class="bg-white border rounded-2xl px-4 py-5">
            <p class="text-sm font-semibold mb-2">Total Laporan</p>
            <p class="text-3xl font-bold">{{ $total }}</p>
        </section>

        <section class="bg-white border rounded-2xl px-4 py-5">
            <p class="text-sm font-semibold mb-2">Menunggu</p>
            <p class="text-3xl font-bold">{{ $pending }}</p>
        </section>

        <section class="bg-white border rounded-2xl px-4 py-5">
            <p class="text-sm font-semibold mb-2">Proses/Selesai</p>
            <p class="text-3xl font-bold">{{ $prosesSelesai }}</p>
        </section>

    </main>

</body>
</html>
