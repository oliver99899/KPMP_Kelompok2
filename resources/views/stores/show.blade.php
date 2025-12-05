<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seller->store_name }} - KPMP Market</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234F46E5' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L5.1 14.9C4.7 15.3 4.7 16 5.1 16.4C5.5 16.8 6.2 16.8 6.6 16.4L7 16M7 13H17M17 13V13.2C17 13.9 17.5 14.4 18.2 14.4C18.9 14.4 19.4 13.9 19.4 13.2V13M9 20C9 20.6 8.6 21 8 21C7.4 21 7 20.6 7 20C7 19.4 7.4 19 8 19C8.6 19 9 19.4 9 20ZM19 20C19 20.6 18.6 21 18 21C17.4 21 17 20.6 17 20C17 19.4 17.4 19 18 19C18.6 19 19 19.4 19 20Z'/></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-50 font-sans text-gray-900">

    {{-- NAVBAR SIMPLE --}}
    <nav class="bg-white border-b border-gray-200 py-4 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <a href="/" class="p-2 rounded-full hover:bg-gray-100 transition-colors group" title="Kembali ke Katalog">
                <svg class="w-6 h-6 text-indigo-600 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div class="text-sm font-medium text-gray-500">Profil Toko</div>
        </div>
    </nav>

    {{-- HEADER INFORMASI TOKO --}}
    <div class="bg-white border-b border-gray-200 mb-8">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row gap-6 md:gap-10 items-start">
                
                {{-- Logo Toko (Inisial) --}}
                <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-4xl uppercase shadow-inner border-4 border-white flex-shrink-0">
                    {{ substr($seller->store_name, 0, 1) }}
                </div>

                <div class="flex-1 w-full">
                    {{-- Nama & Lokasi --}}
                    <h1 class="text-3xl font-black text-gray-900 mb-2">{{ $seller->store_name }}</h1>
                    <div class="flex items-center gap-2 text-gray-500 text-sm mb-4 bg-gray-50 w-fit px-3 py-1 rounded-full border border-gray-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="font-semibold">{{ $seller->pic_city }}, {{ $seller->pic_province }}</span>
                    </div>

                    {{-- DESKRIPSI LIPAT (Alpine JS) --}}
                    <div x-data="{ expanded: false }" class="text-gray-600 text-sm leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100 relative">
                        <div :class="expanded ? '' : 'line-clamp-2'" class="transition-all duration-300">
                            {{ $seller->store_description ?? 'Penjual ini belum menambahkan deskripsi toko.' }}
                        </div>
                        
                        {{-- Tombol Buka/Tutup hanya muncul jika deskripsi panjang --}}
                        @if(strlen($seller->store_description) > 150)
                            <button @click="expanded = !expanded" class="text-indigo-600 font-bold text-xs mt-2 hover:underline focus:outline-none flex items-center gap-1">
                                <span x-text="expanded ? 'Tutup Deskripsi' : 'Baca Selengkapnya'"></span>
                                <svg class="w-3 h-3 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- KONTEN PRODUK --}}
    <div class="max-w-7xl mx-auto px-4 pb-12">
        
        {{-- FILTER KATEGORI TOKO --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-900 text-lg">Etalase Toko</h3>
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-md">{{ $products->total() }} Produk</span>
            </div>
            
            <div class="flex gap-3 overflow-x-auto pb-2 no-scrollbar">
                <a href="{{ route('store.show', $seller->id) }}" class="px-5 py-2 rounded-full text-sm font-bold border transition shadow-sm {{ !request('category') ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:border-indigo-300 hover:text-indigo-600' }}">
                    Semua Produk
                </a>
                @foreach($storeCategories as $cat)
                    <a href="{{ route('store.show', ['id' => $seller->id, 'category' => $cat->id]) }}" class="px-5 py-2 rounded-full text-sm font-bold border transition shadow-sm {{ request('category') == $cat->id ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:border-indigo-300 hover:text-indigo-600' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- GRID PRODUK --}}
        @if($products->isEmpty())
            <div class="text-center py-20 bg-white rounded-xl border-2 border-dashed border-gray-200">
                <div class="text-4xl mb-2">📦</div>
                <p class="text-gray-500 font-medium">Toko ini belum memiliki produk di kategori ini.</p>
                <a href="{{ route('store.show', $seller->id) }}" class="text-indigo-600 text-sm font-bold hover:underline mt-2 inline-block">Lihat Semua Produk</a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach($products as $product)
                    <div class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col relative h-full transform hover:-translate-y-1">
                        
                        {{-- FOTO --}}
                        <div class="relative h-48 bg-gray-100 overflow-hidden">
                            @if($product->image_path)
                                <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 {{ $product->stock == 0 ? 'grayscale opacity-60' : '' }}">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400 text-xs">No Image</div>
                            @endif
                            @if($product->stock == 0)
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center z-10"><span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg uppercase tracking-wider">Stok Habis</span></div>
                            @endif
                        </div>

                        {{-- INFO --}}
                        <div class="p-4 flex flex-col flex-grow">
                            <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2 group-hover:text-indigo-600 transition leading-relaxed">{{ $product->name }}</h3>
                            
                            {{-- Rating --}}
                            <div class="flex items-center mb-2 h-4">
                                @if($product->reviews_avg_rating > 0)
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span class="text-xs font-bold text-gray-700">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                                        <span class="text-[10px] text-gray-400">({{ $product->reviews_count }})</span>
                                    </div>
                                @else
                                    <span class="text-[10px] text-gray-400">Belum ada ulasan</span>
                                @endif
                            </div>

                            <div class="mt-auto pt-3 border-t border-gray-50">
                                <p class="text-lg font-extrabold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <a href="{{ route('product.show', $product->slug) }}" class="absolute inset-0 z-0"></a>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12 flex justify-center">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</body>
</html>