<x-guest-layout>
    <!-- Backup of login blade -->
    <div>
        <h1 class="text-2xl font-semibold text-gray-800">Masuk ke Akun</h1>
        <p class="mt-1 text-sm text-gray-500">Silakan masukkan email dan kata sandi Anda untuk melanjutkan.</p>

        <!-- Session Status -->
        <x-auth-session-status class="mt-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">Lupa kata sandi?</a>
                @endif
            </div>

            <div class="pt-2">
                <x-primary-button class="w-full">
                    {{ __('Masuk') }}
                </x-primary-button>
            </div>
        </form>

        <div class="mt-4 text-sm text-center text-gray-600">
            Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Daftar</a>
        </div>
    </div>
</x-guest-layout>
