<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>

    {{-- FONT INTER --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
</head>

<body class="bg-[#F5F5F5] font-[Inter]">

    <div class="min-h-screen flex items-center justify-center py-10 px-6">

        {{-- CARD --}}
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl p-10 flex flex-col items-center">

            {{-- LOGO --}}
            <img src="{{ asset('images/logo.png') }}"
                 alt="Logo"
                 class="w-56 mb-8">

            {{-- TITLE --}}
            <h1 class="text-center text-2xl font-bold text-black mb-6">
                Registrasi
            </h1>

            {{-- ERROR VALIDASI --}}
@if ($errors->any())
    <div class="w-full mb-6 rounded-lg border border-red-300 bg-red-50 p-4 text-red-700">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

            {{-- FORM --}}
            <form action="{{ route('register') }}" method="POST" class="w-full">
                @csrf

                {{-- Nama --}}
                <input type="text" name="name" placeholder="Nama"
                    class="w-full border border-gray-300 rounded-lg py-3 px-4 mb-4 focus:ring-2 focus:ring-green-700 focus:outline-none"
                    required>

                {{-- Email --}}
                <input type="email" name="email" placeholder="Email"
                    class="w-full border border-gray-300 rounded-lg py-3 px-4 mb-4 focus:ring-2 focus:ring-green-700 focus:outline-none"
                    required>

                {{-- Password --}}
                <input type="password" name="password" placeholder="Password"
                    class="w-full border border-gray-300 rounded-lg py-3 px-4 mb-4 focus:ring-2 focus:ring-green-700 focus:outline-none"
                    required>

                {{-- Confirm Password --}}
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                    class="w-full border border-gray-300 rounded-lg py-3 px-4 mb-6 focus:ring-2 focus:ring-green-700 focus:outline-none"
                    required>

                {{-- BUTTON --}}
                <button type="submit"
                    class="w-full bg-[#043915] text-white font-semibold py-3 rounded-lg text-center hover:bg-[#065022] transition">
                    Registrasi
                </button>
            </form>

            {{-- SUDAH PUNYA AKUN --}}
            <a href="{{ route('login') }}" 
               class="mt-6 text-sm text-gray-700 font-semibold hover:underline">
                Sudah Punya Akun?
            </a>

        </div>

    </div>

</body>
</html>
