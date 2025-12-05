<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KPMP Market') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234F46E5' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L5.1 14.9C4.7 15.3 4.7 16 5.1 16.4C5.5 16.8 6.2 16.8 6.6 16.4L7 16M7 13H17M17 13V13.2C17 13.9 17.5 14.4 18.2 14.4C18.9 14.4 19.4 13.9 19.4 13.2V13M9 20C9 20.6 8.6 21 8 21C7.4 21 7 20.6 7 20C7 19.4 7.4 19 8 19C8.6 19 9 19.4 9 20ZM19 20C19 20.6 18.6 21 18 21C17.4 21 17 20.6 17 20C17 19.4 17.4 19 18 19C18.6 19 19 19.4 19 20Z'/></svg>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            {{-- HEADER LOGO & TEKS --}}
            <div class="mb-7 text-center">
                <a href="/" class="flex flex-col items-center group">
                    
                    {{-- 1. Ikon Keranjang (Dalam Lingkaran Biru) --}}
                    <div class="bg-indigo-600 p-3 rounded-full text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <x-application-logo class="w-12 h-12" />
                    </div>
                </a>
            </div>

            {{-- KOTAK FORMULIR --}}
            <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-gray-100">
                {{ $slot }}
            </div>

            {{-- FOOTER COPYRIGHT --}}
            <div class="mt-8 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} KPMP Kelompok 2 All rights reserved.
            </div>
        </div>
    </body>
</html>