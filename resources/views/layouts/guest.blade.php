<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-sky-50 to-indigo-50">
        <header class="w-full bg-white/70 backdrop-blur-sm shadow-sm">
            <div class="max-w-5xl mx-auto px-4 py-3 flex items-center gap-3">
                <a href="/" class="flex items-center gap-3">
                    <x-application-logo class="w-10 h-10 fill-current text-indigo-600" />
                    <span class="text-lg font-semibold text-indigo-700">{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>
        </header>

        <main class="min-h-[calc(100vh-72px)] flex items-center justify-center py-10">
            <div class="w-full sm:max-w-2xl mx-4 grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <div class="hidden md:flex flex-col justify-center px-6 py-8 bg-indigo-600 text-white rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold">Selamat Datang</h2>
                    <p class="mt-3 text-sm opacity-90">Masuk untuk mengelola data mahasiswa dan melihat dashboard aplikasi.</p>
                    <div class="mt-6">
                        <img src="/storage/login-illustration.svg" alt="illustration" class="w-full opacity-95"/>
                    </div>
                </div>

                <div class="px-6 py-8 bg-white shadow-md rounded-lg">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </body>
</html>
