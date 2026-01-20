<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan</title>

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
            Buat Laporan
        </h1>
    </header>

    <main class="px-4 py-6 max-w-xl mx-auto">

        {{-- ERROR VALIDASI (opsional) --}}
        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('user.reports.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {{-- Judul --}}
            <div>
                <label for="title" class="block text-sm font-semibold mb-1">Judul</label>
                <input id="title" name="title" type="text"
                       class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#043915] focus:outline-none"
                       required maxlength="150" value="{{ old('title') }}">
            </div>

            {{-- Kategori (opsional) --}}
            <div>
                <label for="category" class="block text-sm font-semibold mb-1">Kategori (opsional)</label>
                <input id="category" name="category" type="text"
                       class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#043915] focus:outline-none"
                       maxlength="50" value="{{ old('category') }}">
            </div>

            {{-- Isi laporan --}}
            <div>
                <label for="body" class="block text-sm font-semibold mb-1">Isi Laporan</label>
                <textarea id="body" name="body" rows="5"
                          class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#043915] focus:outline-none"
                          required>{{ old('body') }}</textarea>
            </div>

            {{-- Foto --}}
            <div>
                <label for="photo" class="block text-sm font-semibold mb-1">
                    Foto (opsional, JPG/PNG/WEBP maks 2MB)
                </label>
                <input id="photo" name="photo" type="file"
                       class="w-full border rounded-lg px-3 py-2 text-sm bg-white"
                       accept=".jpg,.jpeg,.png,.webp">
            </div>

            {{-- Button --}}
            <button type="submit"
                    class="mt-2 bg-[#043915] text-white font-semibold px-6 py-2 rounded-lg hover:bg-[#065022] transition">
                Kirim Laporan
            </button>
        </form>

    </main>

</body>
</html>
