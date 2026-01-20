<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $report->title }} - Pengaduan</title>

    {{-- FONT INTER --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
</head>

<body class="bg-[#F5F5F5] font-[Inter]">

    {{-- HEADER --}}
    @php
        $from = request()->query('from');
        $backUrl = $from === 'latest'
            ? route('admin.laporan-terbaru')
            : route('admin.reports.index');
    @endphp

    <header class="bg-[#043915] py-4 px-4 flex items-center gap-3">
        <a href="{{ $backUrl }}" class="p-1">
            <img src="{{ asset('images/left-arrow-white.png') }}" alt="Kembali" class="w-6 h-6">
        </a>
        <h1 class="text-white text-xl font-bold">
            Pengaduan
        </h1>
    </header>

    <main class="px-4 py-6 space-y-5 max-w-2xl mx-auto">

        @php
            $status = $report->status ?? 'pending';
            $statusMap = [
                'pending'    => ['label' => 'Menunggu',  'bg' => '#FFFD8F', 'text' => '#B45309'],
                'resolved'   => ['label' => 'Selesai',   'bg' => '#026522', 'text' => '#FFFFFF'],
                'in_process' => ['label' => 'Diproses',  'bg' => '#00479F', 'text' => '#FFFFFF'],
            ];
            $current = $statusMap[$status] ?? $statusMap['pending'];
        @endphp

        {{-- CARD DETAIL LAPORAN --}}
        <section class="bg-white rounded-2xl border px-4 py-5">
            {{-- Judul + status --}}
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h2 class="text-lg font-bold mb-1">
                        {{ $report->title }}
                    </h2>
                    <p class="text-xs text-gray-500">
                        Dibuat: {{ $report->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        Pelapor: {{ $report->user->name }}
                    </p>
                    @if ($report->category)
                        <p class="text-xs text-gray-500 mt-1">
                            Kategori: {{ $report->category }}
                        </p>
                    @endif
                </div>

                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold"
                      style="background-color: {{ $current['bg'] }}; color: {{ $current['text'] }};">
                    {{ $current['label'] }}
                </span>
            </div>

            {{-- Isi laporan --}}
            <p class="mt-4 text-sm leading-relaxed whitespace-pre-line">
                {{ $report->body }}
            </p>

            {{-- Foto laporan --}}
            <div class="mt-5">
                @if ($report->photo_url)
                    <img
                        src="{{ $report->photo_url }}"
                        alt="Foto laporan"
                        class="w-full rounded-2xl object-cover max-h-80"
                    >
                @else
                    <div class="bg-gray-200 rounded-2xl h-48 flex items-center justify-center text-gray-700 font-semibold">
                        foto laporan
                    </div>
                @endif
            </div>
        </section>

        {{-- CARD KIRIM TANGGAPAN --}}
        <section class="bg-white rounded-2xl border px-4 py-5">
            <h2 class="text-lg font-bold mb-4">Kirim Tanggapan</h2>

            {{-- ALERT --}}
            @if (session('success'))
                <div class="mb-4 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-3 py-2">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg px-3 py-2">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $statusOrder = ['pending' => 0, 'in_process' => 1, 'resolved' => 2];
                $currentStatus = $report->status ?? 'pending';
                $currentRank = $statusOrder[$currentStatus] ?? 0;
                $statusLocked = $currentStatus === 'resolved';
            @endphp

            <form method="POST" action="{{ route('admin.reports.respond', $report) }}" class="space-y-4">
                @csrf

                {{-- supaya tombol back tetap kembali ke halaman asal (mis. Laporan Terbaru) --}}
                <input type="hidden" name="from" value="{{ request()->query('from') }}">

                {{-- Pesan --}}
                <div>
                    <label for="message" class="block text-sm font-semibold mb-1">Pesan</label>
                    <textarea id="message" name="message" rows="4"
                              class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#043915]"
                              required>{{ old('message') }}</textarea>
                </div>

                {{-- Ubah Status --}}
                <div>
                    <label for="status" class="block text-sm font-semibold mb-1">Ubah Status</label>
                    <select id="status" name="status"
                            class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#043915]"
                            {{ $statusLocked ? 'disabled' : '' }}>

                        @if (($statusOrder['pending'] ?? 0) >= $currentRank)
                            <option value="pending" {{ $currentStatus === 'pending' ? 'selected' : '' }}>Menunggu</option>
                        @endif
                        @if (($statusOrder['in_process'] ?? 1) >= $currentRank)
                            <option value="in_process" {{ $currentStatus === 'in_process' ? 'selected' : '' }}>Diproses</option>
                        @endif
                        @if (($statusOrder['resolved'] ?? 2) >= $currentRank)
                            <option value="resolved" {{ $currentStatus === 'resolved' ? 'selected' : '' }}>Selesai</option>
                        @endif
                    </select>

                    {{-- Kalau sudah selesai, status dikunci dan tetap dikirim via hidden input --}}
                    @if ($statusLocked)
                        <input type="hidden" name="status" value="resolved">
                        <p class="mt-2 text-xs text-gray-500">Status sudah <b>Selesai</b> dan tidak dapat diubah lagi.</p>
                    @endif
                </div>

                {{-- Button --}}
                <button type="submit"
                        class="inline-flex items-center justify-center bg-[#043915] text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-[#065022] transition">
                    Kirim &amp; Simpan
                </button>
            </form>
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
