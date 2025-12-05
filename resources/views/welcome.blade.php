<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KPMP Market</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234F46E5' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L5.1 14.9C4.7 15.3 4.7 16 5.1 16.4C5.5 16.8 6.2 16.8 6.6 16.4L7 16M7 13H17M17 13V13.2C17 13.9 17.5 14.4 18.2 14.4C18.9 14.4 19.4 13.9 19.4 13.2V13M9 20C9 20.6 8.6 21 8 21C7.4 21 7 20.6 7 20C7 19.4 7.4 19 8 19C8.6 19 9 19.4 9 20ZM19 20C19 20.6 18.6 21 18 21C17.4 21 17 20.6 17 20C17 19.4 17.4 19 18 19C18.6 19 19 19.4 19 20Z'/></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">
    
    {{-- NAVBAR --}}
    <nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center gap-8">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <a href="/" class="flex items-center gap-2 group">
                        <div class="text-indigo-600 group-hover:scale-110 transition-transform duration-200">
                            <x-application-logo class="block h-10 w-auto fill-current" />
                        </div>
                        <span class="font-bold text-2xl text-indigo-600 tracking-tight">KPMP Market</span>
                    </a>
                </div>
                <div class="flex-1 max-w-3xl">
                    <form action="{{ route('home') }}" method="GET" class="flex shadow-sm rounded-lg border border-gray-300 overflow-hidden focus-within:ring-2 focus-within:ring-indigo-500 bg-white">
                        <select name="type" class="bg-gray-50 border-0 text-gray-700 text-sm font-bold px-4 py-2.5 focus:ring-0 cursor-pointer hover:bg-gray-100 border-r border-gray-300" onchange="this.form.submit()">
                            <option value="product" {{ request('type') == 'product' ? 'selected' : '' }}>Produk</option>
                            <option value="store" {{ request('type') == 'store' ? 'selected' : '' }}>Toko</option>
                        </select>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="w-full border-0 py-2.5 px-4 text-sm focus:ring-0">
                        <button type="submit" class="bg-indigo-600 px-6 flex items-center justify-center text-white hover:bg-indigo-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </form>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-gray-700 hover:text-indigo-600 transition">Dashboard</a>
                        <div class="h-8 w-px bg-gray-200"></div>
                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">{{ substr(Auth::user()->name, 0, 1) }}</div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 hover:text-indigo-600 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-bold hover:bg-indigo-700 transition shadow-md">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form action="{{ route('home') }}" method="GET" id="filterForm">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="type" value="{{ request('type', 'product') }}">

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                @if($isSearching)
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 sticky top-28">
                            <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-3">
                                <h3 class="font-bold text-gray-900 text-lg">Filter</h3>
                                <a href="{{ route('home', request()->only(['search', 'type'])) }}" class="text-xs text-red-500 hover:text-red-700 font-bold">Reset</a>
                            </div>

                            <div x-data="{ open: true }" class="border-b border-gray-100 pb-4 mb-4">
                                <button type="button" @click="open = !open" class="flex justify-between items-center w-full text-sm font-bold text-gray-800 mb-3">Propinsi <svg class="w-4 h-4" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></button>
                                <div x-show="open" class="space-y-2 max-h-60 overflow-y-auto custom-scrollbar">
                                    @foreach($allProvinces as $prov)
                                        <label class="flex items-center gap-3 cursor-pointer hover:text-indigo-600"><input type="checkbox" name="provinces[]" value="{{ $prov }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4" {{ in_array($prov, request('provinces', [])) ? 'checked' : '' }} onchange="this.form.submit()"><span class="text-sm text-gray-600">{{ $prov }}</span></label>
                                    @endforeach
                                </div>
                            </div>

                            <div x-data="{ open: true }" class="border-b border-gray-100 pb-4 mb-4">
                                <button type="button" @click="open = !open" class="flex justify-between items-center w-full text-sm font-bold text-gray-800 mb-3">Kota <svg class="w-4 h-4" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></button>
                                <div x-show="open" class="space-y-2 max-h-60 overflow-y-auto custom-scrollbar">
                                    @foreach($allCities as $city)
                                        <label class="flex items-center gap-3 cursor-pointer hover:text-indigo-600"><input type="checkbox" name="cities[]" value="{{ $city }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4" {{ in_array($city, request('cities', [])) ? 'checked' : '' }} onchange="this.form.submit()"><span class="text-sm text-gray-600">{{ $city }}</span></label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- FILTER HARGA (HANYA MUNCUL JIKA BUKAN MODE TOKO) --}}
                            @if(request('type') != 'store')
                                <div x-data="{ open: true }">
                                    <button type="button" @click="open = !open" class="flex justify-between items-center w-full text-sm font-bold text-gray-800 mb-3 hover:text-indigo-600">Harga <svg class="w-4 h-4" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></button>
                                    <div x-show="open" class="space-y-3">
                                        <div class="relative"><span class="absolute left-3 top-2.5 text-gray-400 text-xs">Rp</span><input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg text-sm"></div>
                                        <div class="relative"><span class="absolute left-3 top-2.5 text-gray-400 text-xs">Rp</span><input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg text-sm"></div>
                                        <button type="submit" class="w-full bg-indigo-50 text-indigo-700 font-bold py-2 rounded-lg text-xs hover:bg-indigo-100 transition mt-1">Terapkan</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="{{ $isSearching ? 'lg:col-span-3' : 'lg:col-span-4' }}">
                    @if(!$isSearching)
                        <div class="bg-white shadow-sm border border-gray-100 rounded-xl p-4 mb-6">
                            <div class="flex gap-3 overflow-x-auto pb-2 no-scrollbar items-center">
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mr-2">Kategori:</span>
                                <a href="{{ route('home') }}" class="px-4 py-1.5 rounded-full text-sm font-medium bg-indigo-600 text-white shadow-md">Semua</a>
                                @foreach($allCategories as $cat)
                                    <a href="{{ route('home', ['category' => $cat->id]) }}" class="px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-gray-200 transition">{{ $cat->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="mb-6"><h2 class="text-xl font-bold text-gray-900">Hasil Pencarian</h2><p class="text-sm text-gray-500">Menampilkan {{ request('type') == 'store' ? $sellers->total() : $products->total() }} hasil</p></div>
                    @endif

                    @if(request('type', 'product') == 'product')
                        @if($products->isEmpty())
                            <div class="bg-white p-10 rounded-xl text-center border border-gray-100"><h3 class="text-lg font-bold text-gray-900">Produk tidak ditemukan</h3></div>
                        @else
                            <div class="grid grid-cols-2 md:grid-cols-3 {{ $isSearching ? 'lg:grid-cols-3 xl:grid-cols-4' : 'lg:grid-cols-4 xl:grid-cols-5' }} gap-6">
                                @foreach($products as $product)
                                    <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col relative h-full">
                                        <div class="relative h-48 bg-gray-100 overflow-hidden">
                                            @if($product->image_path) <img src="{{ asset('storage/'.$product->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 {{ $product->stock == 0 ? 'grayscale' : '' }}"> @else <div class="flex items-center justify-center h-full text-gray-400 text-xs">No Image</div> @endif
                                            @if($product->stock == 0) <div class="absolute inset-0 bg-black/40 flex items-center justify-center z-10"><span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg uppercase tracking-wider">Stok Habis</span></div> @endif
                                        </div>
                                        <div class="p-4 flex flex-col flex-grow">
                                            <p class="text-[10px] text-indigo-500 font-bold uppercase mb-1">{{ $product->category->name }}</p>
                                            <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2">{{ $product->name }}</h3>
                                            <div class="flex items-center mb-2 h-5">
                                                @if($product->reviews_avg_rating > 0)
                                                    <div class="flex items-center bg-gray-50 px-1.5 py-0.5 rounded border border-gray-100"><svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg><span class="ml-1 text-xs font-bold text-gray-700">{{ number_format($product->reviews_avg_rating, 1) }}</span><span class="ml-1 text-[10px] text-gray-400">({{ $product->reviews_count }})</span></div>
                                                @endif
                                            </div>
                                            <div class="mt-auto pt-3 border-t border-gray-50"><p class="text-lg font-extrabold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p><div class="flex items-center gap-1 text-xs text-gray-500 mt-1"><span class="truncate">{{ $product->seller->pic_city }}</span></div></div>
                                        </div>
                                        <a href="{{ route('product.show', $product->slug) }}" class="absolute inset-0 z-0"></a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-12 flex justify-center">{{ $products->appends(request()->query())->links() }}</div>
                        @endif
                    @elseif(request('type') == 'store')
                        @if($sellers->isEmpty())
                            <div class="bg-white p-10 rounded-xl text-center border border-gray-100"><h3 class="text-lg font-bold text-gray-900">Toko tidak ditemukan</h3></div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($sellers as $seller)
                                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition flex items-center gap-4 relative group">
                                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-2xl uppercase">{{ substr($seller->store_name, 0, 1) }}</div>
                                        <div>
                                            <h3 class="font-bold text-gray-900 text-lg group-hover:text-indigo-600 transition">{{ $seller->store_name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $seller->pic_city }}, {{ $seller->pic_province }}</p>
                                            <p class="text-xs text-indigo-600 mt-1 font-semibold">{{ $seller->products_count }} Produk</p>
                                        </div>
                                        {{-- LINK KE DETAIL TOKO (BARU) --}}
                                        <a href="{{ route('store.show', $seller->id) }}" class="absolute inset-0 z-0"></a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-8">{{ $sellers->appends(request()->query())->links() }}</div>
                        @endif
                    @endif
                </div>
            </div>
        </form>
    </div>
</body>
</html>