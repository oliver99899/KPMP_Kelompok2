<x-guest-layout>
    
    <!-- JUDUL HALAMAN: LUPA PASSWORD -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-400 tracking-wider uppercase">
            LUPA PASSWORD
        </h2>
        <p class="text-sm text-gray-400 mt-2">
            {{ __('Masukkan email Anda untuk reset password') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700" />
            <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Tombol Kirim Link (Warna Ungu Indigo) -->
        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors mt-6">
            {{ __('Kirim Link Reset Password') }}
        </button>

        <!-- Link Kembali ke Login -->
        <div class="mt-6 text-center border-t border-gray-100 pt-4">
            <p class="text-sm text-gray-600">
                Ingat password Anda? 
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-bold hover:underline">
                    Kembali ke Login
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>