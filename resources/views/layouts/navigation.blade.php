{{-- LOGIKA STATUS USER --}}
@php
    $user = Auth::user();
    $navSeller = \App\Models\Seller::where('user_id', $user->id)->first();
    
    $isNavSellerActive = $navSeller && $navSeller->status === 'ACTIVE';
    $isNavSellerPending = $navSeller && $navSeller->status === 'PENDING';
    
    // TAMBAHAN: Cek Status REJECTED (Ditolak)
    $isNavSellerRejected = $navSeller && $navSeller->status === 'REJECTED'; 

    $isAdmin = $user->role === 'ADMIN';
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            {{-- BAGIAN KIRI: LOGO & MENU UTAMA --}}
            <div class="flex">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                        <div class="text-indigo-600 group-hover:scale-110 transition-transform duration-200">
                            <x-application-logo class="block h-9 w-auto fill-current" />
                        </div>
                        <span class="font-bold text-xl text-indigo-600 tracking-tight">KPMP Market</span>
                    </a>
                </div>

                {{-- Menu Desktop --}}
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    
                    {{-- 1. Menu Dashboard --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-600 hover:text-indigo-600 font-medium">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- 2. Menu KHUSUS ADMIN --}}
                    @if($isAdmin)
                        <x-nav-link :href="route('admin.sellers.index')" :active="request()->routeIs('admin.sellers.*')" class="text-gray-600 hover:text-indigo-600 font-medium">
                            {{ __('Verifikasi Penjual') }}
                        </x-nav-link>
                    @endif

                    {{-- 3. Menu KHUSUS PENJUAL (Jika Bukan Admin) --}}
                    @if(!$isAdmin)
                        @if(!$navSeller)
                            {{-- A. Belum Punya Toko -> Buka Toko --}}
                            <x-nav-link :href="route('seller.register')" :active="request()->routeIs('seller.register')" class="text-indigo-600 font-bold">
                                + {{ __('Buka Toko Gratis') }}
                            </x-nav-link>
                        
                        @elseif($isNavSellerPending)
                            {{-- B. Menunggu Verifikasi (Teks Kuning) --}}
                            <div class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-yellow-600">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> 
                                    Menunggu Verifikasi
                                </span>
                            </div>

                        @elseif($isNavSellerRejected)
                            {{-- C. DITOLAK (Teks Merah & Link ke Register untuk Perbaikan) --}}
                            <x-nav-link :href="route('seller.register')" :active="request()->routeIs('seller.register')" class="text-red-600 font-bold hover:text-red-800">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    Pengajuan Ditolak (Perbaiki)
                                </span>
                            </x-nav-link>

                        @elseif($isNavSellerActive)
                            {{-- D. Toko Aktif -> Kelola Produk --}}
                            <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="text-gray-600 hover:text-indigo-600">
                                {{ __('Produk Saya') }}
                            </x-nav-link>
                        @endif
                    @endif
                </div>
            </div>

            {{-- BAGIAN KANAN: USER DROPDOWN --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                
                {{-- Link Balik ke Katalog --}}
                <a href="{{ route('home') }}" class="mr-4 text-sm text-gray-500 hover:text-indigo-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Ke Katalog
                </a>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile Saya') }}</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                                {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- HAMBURGER MOBILE --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /><path :class="{'hidden': open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENU MOBILE --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('home')">
                Ke Katalog Depan
            </x-responsive-nav-link>

            {{-- Mobile: Menu Admin --}}
            @if($isAdmin)
                <x-responsive-nav-link :href="route('admin.sellers.index')" :active="request()->routeIs('admin.sellers.*')" class="text-indigo-600">
                    {{ __('Verifikasi Penjual') }}
                </x-responsive-nav-link>
            @endif

            {{-- Mobile: Menu Penjual --}}
            @if(!$isAdmin)
                @if(!$navSeller)
                    <x-responsive-nav-link :href="route('seller.register')" class="text-indigo-600 font-bold">Buka Toko</x-responsive-nav-link>
                @elseif($isNavSellerPending)
                    <div class="px-4 py-2 text-sm font-medium text-yellow-600 border-l-4 border-yellow-400 bg-yellow-50">Menunggu Verifikasi</div>
                @elseif($isNavSellerRejected)
                    <x-responsive-nav-link :href="route('seller.register')" class="text-red-600 font-bold">Pengajuan Ditolak (Perbaiki)</x-responsive-nav-link>
                @elseif($isNavSellerActive)
                    <x-responsive-nav-link :href="route('products.index')">Produk Saya</x-responsive-nav-link>
                @endif
            @endif
        </div>

        {{-- Mobile: User Info --}}
        <div class="pt-4 pb-4 border-t border-gray-200 px-4">
            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">Keluar</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>