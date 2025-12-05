<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KPMP Market</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">
    
    {{-- NAVBAR --}}
    <nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <a href="/" class="flex items-center gap-2 group">
                        <div class="text-indigo-600 group-hover:scale-110 transition-transform duration-200">
                            <x-application-logo class="block h-9 w-auto fill-current" />
                        </div>
                        <span class="font-bold text-xl text-indigo-600 tracking-tight">KPMP Market</span>
                    </a>
                </div>
                <div class="hidden md:block flex-1 max-w-lg mx-8">
                    <form action="{{ route('home') }}" method="GET">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk apa hari ini?" class="w-full rounded-full border-gray-300 pl-4 pr-10 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                            <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-400 hover:text-indigo-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-indigo-600 text-white rounded-full text-sm font-bold hover:bg-indigo-700 transition shadow-md">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- KATEGORI --}}
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex gap-3 overflow-x-auto pb-2 no-scrollbar">
                <a href="{{ route('home') }}" class="px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap transition {{ !request('category') ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Semua</a>
                @foreach($categories as $cat)
                    <a href="{{ route('home', ['category' => $cat->id]) }}" class="px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap transition {{ request('category') == $cat->id ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- GRID PRODUK --}}
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($products->isEmpty())
                <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900">Produk tidak ditemukan</h3>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    @foreach($products as $product)
                        <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col relative h-full">
                            
                            {{-- FOTO --}}
                            <div class="relative h-48 bg-gray-100 overflow-hidden">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 {{ $product->stock == 0 ? 'grayscale opacity-60' : '' }}">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400 text-xs">No Image</div>
                                @endif
                                @if($product->stock == 0)
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center z-10">
                                        <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg uppercase tracking-wider">Stok Habis</span>
                                    </div>
                                @endif
                            </div>

                            {{-- INFO --}}
                            <div class="p-4 flex flex-col flex-grow">
                                <p class="text-[10px] text-indigo-500 font-bold uppercase tracking-wider mb-1">{{ $product->category->name }}</p>
                                <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2 leading-tight group-hover:text-indigo-600 transition-colors">{{ $product->name }}</h3>
                                
                                {{-- >>> RATING BINTANG EMAS (INI YANG ANDA CARI) <<< --}}
                                <div class="flex items-center mb-2 h-5">
                                    @if($product->reviews_avg_rating > 0)
                                        <div class="flex items-center bg-gray-50 px-1.5 py-0.5 rounded border border-gray-100">
                                            {{-- Ikon Bintang Kuning --}}
                                            <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            
                                            {{-- Angka Rating (4.5) --}}
                                            <span class="ml-1 text-xs font-bold text-gray-700">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                                            
                                            {{-- Jumlah Ulasan (10) --}}
                                            <span class="ml-1 text-[10px] text-gray-400">({{ $product->reviews_count }})</span>
                                        </div>
                                    @else
                                        <span class="text-[10px] text-gray-400">Belum ada ulasan</span>
                                    @endif
                                </div>
                                {{-- >>> SELESAI BAGIAN RATING <<< --}}

                                <div class="mt-auto pt-3 border-t border-gray-50">
                                    <p class="text-lg font-extrabold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <div class="flex items-center gap-1 text-xs text-gray-500 mt-1">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span class="truncate">{{ $product->seller->pic_city }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Link Pembungkus --}}
                            <a href="{{ route('product.show', $product->slug) }}" class="absolute inset-0 z-0"></a>
                        </div>
                    @endforeach
                </div>
                <div class="mt-12 flex justify-center">{{ $products->appends(request()->query())->links() }}</div>
            @endif
        </div>
    </div>
</body>
</html>