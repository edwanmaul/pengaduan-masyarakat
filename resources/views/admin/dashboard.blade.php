<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    {{-- FONT INTER --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
</head>

<body class="bg-[#F5F5F5] font-[Inter]">

    {{-- HEADER --}}
    <header class="bg-[#043915] py-4 px-6 flex justify-between items-center">
        <h1 class="text-white text-2xl font-bold">Admin</h1>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="bg-[#D30000] text-white font-semibold px-6 py-2 rounded-lg hover:bg-red-700 transition">
                Logout
            </button>
        </form>
    </header>

    {{-- MAIN CONTENT --}}
    <div class="px-6 py-8 flex flex-col items-center">

        {{-- LOGO BESAR --}}
        <img src="{{ asset('images/logo.png') }}"
             alt="Logo"
             class="w-64 mb-8">

        {{-- CARD LIHAT LAPORAN TERBARU --}}
        <div class="bg-white border rounded-2xl p-6 w-full max-w-lg flex items-center justify-between mb-8">

            {{-- ICON BACKGROUND --}}
            <div class="bg-[#DFF5E0] p-4 rounded-xl">
                <img src="{{ asset('images/loudspeaker.png') }}" class="w-12" alt="megaphone">
            </div>

            {{-- BUTTONS --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.laporan-terbaru') }}"
                    class="bg-[#043915] text-white font-semibold text-sm px-6 py-3 rounded-lg hover:bg-[#065022] transition text-center">
                    Lihat <br> Laporan Terbaru
                </a>

                <a href="{{ route('admin.reports.export.csv') }}"
                    class="bg-[#00479F] text-white font-semibold text-sm px-6 py-3 rounded-lg hover:opacity-90 transition text-center">
                    Export CSV
                </a>
            </div>
        </div>

        {{-- TOTAL LAPORAN --}}
        <div class="bg-white border rounded-2xl p-6 w-full max-w-lg mb-5">
            <p class="text-lg font-semibold">Total Laporan</p>
            <p class="text-4xl font-bold mt-2">{{ $total }}</p>
        </div>

        {{-- MENUNGGU --}}
        <div class="bg-white border rounded-2xl p-6 w-full max-w-lg mb-5">
            <p class="text-lg font-semibold">Menunggu</p>
            <p class="text-4xl font-bold mt-2">{{ $pending }}</p>
        </div>

        {{-- SELESAI --}}
        <div class="bg-white border rounded-2xl p-6 w-full max-w-lg mb-5">
            <p class="text-lg font-semibold">Proses Selesai</p>
            <p class="text-4xl font-bold mt-2">{{ $processDone }}</p>
        </div>

    </div>

</body>
</html>
