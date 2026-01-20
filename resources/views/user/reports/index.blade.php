<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Saya</title>

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
            Laporan Saya
        </h1>
    </header>

    <main class="px-4 py-6">

        @forelse ($reports as $item)
            @php
                $status = $item->status ?? 'pending';
                $statusMap = [
                    'pending'    => ['label' => 'Menunggu',  'bg' => '#FFFD8F', 'text' => '#B45309'],
                    'resolved'   => ['label' => 'Selesai',   'bg' => '#026522', 'text' => '#FFFFFF'],
                    'in_process' => ['label' => 'Diproses',  'bg' => '#00479F', 'text' => '#FFFFFF'],
                ];
                $current = $statusMap[$status] ?? $statusMap['pending'];
            @endphp

            <div class="bg-white border rounded-2xl p-4 mb-5 max-w-xl mx-auto">

                {{-- Foto laporan --}}
                @if ($item->photo_url)
                    <img src="{{ $item->photo_url }}"
                         alt="Foto laporan"
                         class="w-full h-32 object-cover rounded-2xl mb-4">
                @else
                    <div class="bg-gray-200 rounded-2xl h-32 mb-4 flex items-center justify-center text-gray-600 text-sm">
                        foto laporan
                    </div>
                @endif

                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="font-bold text-base">
                            {{ $item->title }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            Dibuat: {{ $item->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                        </p>

                        <a href="{{ route('user.reports.show', $item) }}"
                           class="text-xs underline mt-1 inline-block text-black">
                            Lihat Detail
                        </a>
                    </div>

                    <div class="flex items-end">
                        <span class="inline-block px-4 py-1 rounded-full text-xs font-semibold"
                              style="background-color: {{ $current['bg'] }}; color: {{ $current['text'] }};">
                            {{ $current['label'] }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 mt-10">
                Kamu belum membuat laporan.
            </p>
        @endforelse

    </main>

</body>
</html>
