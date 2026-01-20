<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

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
                Login
            </h1>

            {{-- FORM --}}
            <form action="{{ route('login') }}" method="POST" class="w-full">
                @csrf

                {{-- Email --}}
                <input type="email" name="email" placeholder="Email"
                    class="w-full border border-gray-300 rounded-lg py-3 px-4 mb-4 focus:ring-2 focus:ring-green-700 focus:outline-none"
                    required>

                {{-- Password --}}
                <input type="password" name="password" placeholder="Password"
                    class="w-full border border-gray-300 rounded-lg py-3 px-4 mb-6 focus:ring-2 focus:ring-green-700 focus:outline-none"
                    required>

                {{-- BUTTON LOGIN --}}
                <button type="submit"
                    class="w-full bg-[#043915] text-white font-semibold py-3 rounded-lg text-center hover:bg-[#065022] transition">
                    Login
                </button>
            </form>

            {{-- LUPA PASSWORD --}}
            <a href="{{ route('password.request') }}" 
               class="mt-6 text-sm text-gray-700 font-semibold hover:underline">
                Lupa Password?
            </a>

        </div>

    </div>

</body>
</html>
