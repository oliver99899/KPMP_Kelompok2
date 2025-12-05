<x-guest-layout>
    
    <!-- JUDUL HALAMAN: LOGIN (Medium & Warna Selaras) -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-400 tracking-wider">
            LOGIN
        </h2>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700" />
            <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>
            
            <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <!-- Tombol Login (Warna Ungu Indigo) -->
        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
            Masuk Sekarang
        </button>

        <!-- Link Register -->
        <div class="mt-6 text-center border-t border-gray-100 pt-4">
            <p class="text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-bold hover:underline">
                    Daftar Sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>