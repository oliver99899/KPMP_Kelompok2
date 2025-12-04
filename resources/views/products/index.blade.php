<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Produk Saya') }}
            </h2>
            <a href="{{ route('products.create') }}" class="bg-indigo-600 text-white px-2 py-2 rounded-md hover:bg-indigo-700 text-sm font-bold">
                + Tambah Produk Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Jika Produk Kosong --}}
            @if($products->isEmpty())
                <div class="bg-white p-8 rounded-lg shadow-sm text-center border border-dashed border-gray-300">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada produk</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai jualan dengan menambahkan produk pertama Anda.</p>
                    <div class="mt-6">
                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                            + Tambah Produk
                        </a>
                    </div>
                </div>
            @else
                {{-- Grid Daftar Produk --}}
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            {{-- Foto Produk --}}
                            <div class="relative h-48 bg-gray-200">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400">No Image</div>
                                @endif
                                <div class="absolute top-2 right-2 bg-white px-2 py-1 text-xs font-bold rounded-full shadow">
                                    Stok: {{ $product->stock }}
                                </div>
                            </div>

                            {{-- Info Produk --}}
                            <div class="p-4">
                                <span class="text-xs text-indigo-500 uppercase font-semibold tracking-wide">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                                <h3 class="font-bold text-lg mb-1 truncate" title="{{ $product->name }}">{{ $product->name }}</h3>
                                <p class="text-gray-900 font-bold text-xl">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                
                                {{-- Tombol Aksi (Edit & Hapus) --}}
                                <div class="mt-4 flex justify-between items-center pt-3 border-t border-gray-100">
                                    
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('products.edit', $product->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                        Edit
                                    </a>

                                    {{-- Tombol Hapus (Wajib pakai Form DELETE) --}}
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">
                                            Hapus
                                        </button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>