<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KPMP Market') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            {{-- Logo Shopping Cart (Klik Balik ke Home) --}}
            <div class="mb-6">
                <a href="/" class="flex flex-col items-center group">
                    <div class="bg-indigo-600 p-3 rounded-full text-white shadow-lg group-hover:bg-indigo-700 transition duration-300">
                        <x-application-logo class="w-12 h-12 fill-current" />
                    </div>
                    <span class="mt-2 text-xl font-bold text-gray-700 tracking-tight">KPMP Marketplace</span>
                </a>
            </div>

            {{-- Kotak Form Login/Register --}}
            <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-gray-100">
                
                {{-- Flash Message --}}
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-2 rounded">
                        {{ session('status') }}
                    </div>
                @endif

                {{ $slot }}
            </div>

            <div class="mt-8 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} KPMP Kelompok 2. All rights reserved.
            </div>
        </div>
    </body>
</html>