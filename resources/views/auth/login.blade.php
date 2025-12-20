<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Login - {{ config('app.name', 'Aplikasi') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
    </style>
</head>
<body class="min-h-screen bg-[#2b0b5a] flex items-center justify-center">
    <div class="bg-white rounded-lg w-11/12 sm:w-96 md:w-[520px] p-8 md:p-10 shadow-2xl">
        <div class="flex flex-col items-center">
            <img src="/images/642.jpg" alt="logo" class="h-16 w-16 object-contain mb-4" onerror="this.style.display='none'">
            <h1 class="text-2xl md:text-3xl font-extrabold text-[#2b0b5a] mb-3">Login</h1>
        </div>

        @if(session('status'))
            <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-semibold text-[#2b0b5a] mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                    placeholder="Masukkan email Anda"
                    class="w-full px-4 py-3 rounded-lg border border-[#3b1560] focus:outline-none focus:ring-2 focus:ring-[#3b1560]" />
                @error('email') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-[#2b0b5a] mb-1">Password</label>

                <div class="relative">
                    <input id="password" name="password" type="password" required
                        placeholder="Masukkan password"
                        class="w-full px-4 py-3 rounded-lg border border-[#3b1560] focus:outline-none focus:ring-2 focus:ring-[#3b1560]" />

                    <!-- ICON MATA -->
                    <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer text-gray-600" onclick="togglePassword()">
                        <i id="eyeIcon" class="fa-solid fa-eye"></i>
                    </span>
                </div>

                @error('password') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="inline-flex items-center text-sm text-gray-700">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-[#2b0b5a] focus:ring-[#2b0b5a]" />
                    <span class="ml-2">Remember me</span>
                </label>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-[#2b0b5a] text-white py-3 rounded-xl text-lg font-semibold hover:opacity-95">Login</button>
            </div>
        </form>

        <div class="mt-4 text-sm text-center text-gray-600"></div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById("password");
            const icon = document.getElementById("eyeIcon");

            if (password.type === "password") {
                password.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                password.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>
