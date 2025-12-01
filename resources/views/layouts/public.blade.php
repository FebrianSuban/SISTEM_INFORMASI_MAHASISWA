<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Biodata Mahasiswa')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* small local shadow tweak to mimic design */
        .card-soft-shadow { box-shadow: 0 18px 30px rgba(43,11,90,0.08); }

        /* Animated gradient header to add lively educational feel */
        .hero-gradient {
            background: linear-gradient(90deg, #2b0b5a 0%, #6b2fb3 50%, #2b0b5a 100%);
            background-size: 200% 200%;
            animation: gradientMove 8s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Fade-in and upward motion for cards */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp .56s ease forwards; }

        /* Subtle hover lift for cards */
        .card-hover-lift { transition: transform .28s ease, box-shadow .28s ease; }
        .card-hover-lift:hover { transform: translateY(-6px) scale(1.01); }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header / Hero -->
    <header class="bg-[#2b0b5a] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-32 relative">
                <div class="mx-auto max-w-5xl text-center pt-4 sm:pt-6">
                    <div class="flex flex-col items-center">
                        <img src="/images/642.jpg" alt="logo" class="h-12 sm:h-16 w-auto object-contain mb-1 mx-auto" onerror="this.style.display='none'">
                        <div class="text-xl sm:text-2xl font-extrabold tracking-wider">INSTITUT DIGITAL EKONOMI LPKIA</div>
                        <div class="text-xs sm:text-sm opacity-80">Sistem Informasi Biodata Mahasiswa</div>
                    </div>

                    <!-- Compact controls for small screens -->
                    <div class="mt-3 sm:hidden">
                        <div class="flex items-center justify-center gap-3">
                            @auth
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="bg-white/10 hover:bg-white/20 px-3 py-1 rounded-md text-sm font-medium flex items-center gap-2">
                                        <i class="fas fa-user-shield"></i>
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-white/10 hover:bg-white/20 px-3 py-1 rounded-md text-sm font-medium flex items-center gap-2">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Controls (desktop) positioned at right -->
                <div class="hidden sm:flex absolute right-4 top-1/2 transform -translate-y-1/2">
                    <div class="flex items-center space-x-4">
                        @auth
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="bg-white/10 hover:bg-white/20 px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2">
                                    <i class="fas fa-user-shield"></i>
                                    <span>Admin Panel</span>
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-white/10 hover:bg-white/20 px-4 py-2 rounded-md text-sm font-medium flex items-center gap-2">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Search box floating below header -->
        <div class="mt-8 pb-8">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <form action="{{ route('home') }}" method="GET" class="bg-white rounded-xl p-4 shadow-xl flex items-center gap-3">
                    <input type="text" name="search" placeholder="Cari nama atau NIM mahasiswa..." class="flex-1 border border-transparent focus:border-indigo-300 rounded-lg px-4 py-3 text-gray-700 outline-none" value="{{ request('search') }}" />
                    <button type="submit" class="bg-[#2b0b5a] text-white px-5 py-3 rounded-lg shadow hover:opacity-95">Cari</button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="mt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl text-center font-extrabold text-[#2b0b5a] my-8">Data Mahasiswa</h2>
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-lg mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center text-gray-600">
                <p>&copy; {{ date('Y') }} Biodata Mahasiswa. Sistem Informasi Mahasiswa.</p>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
