<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KPMP Market') }}</title>

        <!-- FAVICON FINAL (Warna Indigo #4F46E5) -->
        <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234F46E5' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L5.1 14.9C4.7 15.3 4.7 16 5.1 16.4C5.5 16.8 6.2 16.8 6.6 16.4L7 16M7 13H17M17 13V13.2C17 13.9 17.5 14.4 18.2 14.4C18.9 14.4 19.4 13.9 19.4 13.2V13M9 20C9 20.6 8.6 21 8 21C7.4 21 7 20.6 7 20C7 19.4 7.4 19 8 19C8.6 19 9 19.4 9 20ZM19 20C19 20.6 18.6 21 18 21C17.4 21 17 20.6 17 20C17 19.4 17.4 19 18 19C18.6 19 19 19.4 19 20Z'/></svg>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="min-h-screen">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow-sm border-b border-gray-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="py-6">
                {{ $slot }}
            </main>
        </div>

        {{-- SCRIPT POPUP ALERT --}}
        <script>
            @if (session('success'))
                Swal.fire({ title: 'Berhasil!', text: "{{ session('success') }}", icon: 'success', confirmButtonColor: '#4F46E5', timer: 3000 });
            @endif
            @if ($errors->any())
                Swal.fire({ title: 'Gagal!', text: 'Mohon periksa kembali inputan Anda.', icon: 'error', confirmButtonColor: '#d33' });
            @endif
            @if (session('error'))
                Swal.fire({ title: 'Info', text: "{{ session('error') }}", icon: 'info', confirmButtonColor: '#d33' });
            @endif
        </script>
    </body>
</html>