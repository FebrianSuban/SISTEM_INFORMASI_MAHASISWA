<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Biodata Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card-soft-shadow { box-shadow: 0 18px 30px rgba(43,11,90,0.08); }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header (styled like public) -->
    <header class="bg-[#2b0b5a] text-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-24 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="/images/642.jpg" alt="logo" class="h-10 w-auto object-contain rounded-sm" onerror="this.style.display='none'">
                    <div>
                        <div class="text-lg font-bold tracking-wide">INSTITUT DIGITAL EKONOMI LPKIA</div>
                        <div class="text-xs opacity-80">Panel Admin - Sistem Biodata Mahasiswa</div>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <nav class="hidden sm:flex sm:space-x-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-white/90 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                        <a href="{{ route('admin.mahasiswa.index') }}" class="text-white/90 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Data Mahasiswa</a>
                        <a href="{{ route('home') }}" target="_blank" class="text-white/90 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Lihat Website</a>
                    </nav>

                    <div class="flex items-center space-x-3">
                        <span class="hidden sm:inline text-white/90">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-white/10 hover:bg-white/20 text-white px-3 py-2 rounded-md text-sm font-medium">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="mt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>
