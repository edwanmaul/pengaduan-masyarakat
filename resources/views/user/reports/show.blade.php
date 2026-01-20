<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $report->title }} - Pengaduan</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="bg-[#F5F5F5] font-[Inter]">

    {{-- HEADER --}}
    <header class="bg-[#043915] py-4 px-4 flex items-center gap-3">
        {{-- Sesuai revisi: tombol back selalu kembali ke dashboard masyarakat --}}
        <a href="{{ route('user.dashboard') }}" class="p-1">
            <img src="{{ asset('images/left-arrow-white.png') }}" alt="Kembali" class="w-6 h-6">
        </a>
        <h1 class="text-white text-xl font-bold">
            Pengaduan
        </h1>
    </header>

    @php
        $status = $report->status ?? 'pending';
        $statusMap = [
            'pending'    => ['label' => 'Menunggu',  'bg' => '#FFFD8F', 'text' => '#B45309'],
            'resolved'   => ['label' => 'Selesai',   'bg' => '#026522', 'text' => '#FFFFFF'],
            'in_process' => ['label' => 'Diproses',  'bg' => '#00479F', 'text' => '#FFFFFF'],
        ];
        $current = $statusMap[$status] ?? $statusMap['pending'];
    @endphp

    <main class="px-4 py-6 space-y-5 max-w-xl mx-auto">

        {{-- CARD DETAIL PENGADUAN --}}
        <section class="bg-white rounded-2xl border px-4 py-5">
            <h2 class="text-lg font-bold mb-1">
                {{ $report->title }}
            </h2>

            {{-- STATUS --}}
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold mt-1"
                  style="background-color: {{ $current['bg'] }}; color: {{ $current['text'] }};">
                {{ $current['label'] }}
            </span>

            {{-- TANGGAL --}}
            <p class="text-xs text-gray-500 mt-2">
                Dibuat: {{ $report->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
            </p>

            {{-- KATEGORI (OPSIONAL) --}}
            @if ($report->category)
                <p class="text-xs text-gray-600 mt-1">
                    Kategori: {{ $report->category }}
                </p>
            @endif

            {{-- ISI LAPORAN --}}
            <div class="mt-4 border rounded-xl px-3 py-2 text-sm text-gray-800 whitespace-pre-line">
                {{ $report->body }}
            </div>

            {{-- FOTO LAPORAN --}}
            <div class="mt-5">
                @if ($report->photo_url)
                    <img src="{{ $report->photo_url }}"
                         alt="Foto laporan"
                         class="w-full rounded-2xl object-cover max-h-80">
                @else
                    <div class="bg-gray-200 rounded-2xl h-48 flex items-center justify-center text-gray-700 font-semibold">
                        foto laporan
                    </div>
                @endif
            </div>
        </section>

        {{-- CARD TANGGAPAN ADMIN --}}
        <section class="bg-white rounded-2xl border px-4 py-5">
            <h2 class="text-lg font-bold mb-3">Tanggapan Admin</h2>

            @forelse ($report->responses as $resp)
                <div class="border rounded-xl px-3 py-3 mb-3">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold">
                            {{ $resp->user->name }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $resp->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                        </p>
                    </div>
                    <p class="mt-2 text-sm whitespace-pre-line">
                        {{ $resp->message }}
                    </p>
                </div>
            @empty
                <div class="border rounded-xl px-3 py-3 text-sm text-gray-500">
                    belum ada tanggapan
                </div>
            @endforelse
        </section>

    </main>

</body>
</html>
