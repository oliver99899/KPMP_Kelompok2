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

        <!-- 1. PANGGIL SWEETALERT2 (CDN) -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="min-h-screen">
            
            {{-- Navigation Bar --}}
            @include('layouts.navigation')

            {{-- Page Heading --}}
            @isset($header)
                <header class="bg-white shadow-sm border-b border-gray-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Page Content --}}
            <main class="py-6">
                {{ $slot }}
            </main>
        </div>

        {{-- 2. SCRIPT POPUP OTOMATIS --}}
        <script>
            // --- KASUS A: SUKSES (Dari Controller with('success')) ---
            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#4F46E5', // Warna Indigo
                    timer: 3000 // Otomatis tutup dalam 3 detik
                });
            @endif

            // --- KASUS B: ERROR VALIDASI (Stok Minus, Kolom Kosong, dll) ---
            @if ($errors->any())
                Swal.fire({
                    title: 'Gagal Disimpan!',
                    html: `
                        <ul style="text-align: left; margin-top: 10px;">
                            @foreach ($errors->all() as $error)
                                <li style="color: red; margin-bottom: 5px;">• {{ $error }}</li>
                            @endforeach
                        </ul>
                    `,
                    icon: 'error',
                    confirmButtonText: 'Perbaiki',
                    confirmButtonColor: '#d33',
                });
            @endif

            // --- KASUS C: ERROR UMUM (Dari Controller with('error')) ---
            @if (session('error'))
                Swal.fire({
                    title: 'Terjadi Kesalahan!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonColor: '#d33'
                });
            @endif
        </script>
    </body>
</html>