<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Masyarakat</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="bg-[#F5F5F5] font-[Inter]">

    {{-- HEADER --}}
    <header class="bg-[#043915] py-4 px-6 flex justify-between items-center">
        <h1 class="text-white text-2xl font-bold">Masyarakat</h1>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="bg-[#D30000] text-white font-semibold px-6 py-2 rounded-lg hover:bg-red-700 transition">
                Logout
            </button>
        </form>
    </header>

    <div class="px-6 py-8 flex flex-col items-center">

        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-64 mb-8">

        {{-- BUAT LAPORAN --}}
        <div class="bg-white border rounded-2xl p-6 w-full max-w-lg flex items-center justify-between mb-6">
            <div class="bg-[#DFF5E0] p-4 rounded-xl">
                <img src="{{ asset('images/loudspeaker.png') }}" class="w-12" alt="Buat laporan">
            </div>

            <a href="{{ route('user.reports.create') }}"
               class="bg-[#043915] text-white font-semibold text-sm px-8 py-3 rounded-lg hover:bg-[#065022] transition">
                Buat <br> Laporan
            </a>
        </div>

        {{-- LAPORAN SAYA --}}
        <div class="bg-white border rounded-2xl p-6 w-full max-w-lg flex items-center justify-between mb-6">
            <div class="bg-[#DFF5E0] p-4 rounded-xl">
                <img src="{{ asset('images/handout.png') }}" class="w-12" alt="Laporan saya">
            </div>

            <a href="{{ route('user.reports.index') }}"
               class="bg-[#043915] text-white font-semibold text-sm px-8 py-3 rounded-lg hover:bg-[#065022] transition">
                Laporan <br> Saya
            </a>
        </div>

        {{-- RINGKASAN (ditaruh di dashboard seperti dashboard admin) --}}
        <div class="bg-white border rounded-2xl p-6 w-full max-w-lg mb-5">
            <p class="text-lg font-semibold">Total Laporan</p>
            <p class="text-4xl font-bold mt-2">{{ $total ?? 0 }}</p>
        </div>

        <div class="bg-white border rounded-2xl p-6 w-full max-w-lg mb-5">
            <p class="text-lg font-semibold">Menunggu</p>
            <p class="text-4xl font-bold mt-2">{{ $pending ?? 0 }}</p>
        </div>

        <div class="bg-white border rounded-2xl p-6 w-full max-w-lg mb-5">
            <p class="text-lg font-semibold">Proses Selesai</p>
            <p class="text-4xl font-bold mt-2">{{ $processDone ?? 0 }}</p>
        </div>

    </div>

</body>
</html>
