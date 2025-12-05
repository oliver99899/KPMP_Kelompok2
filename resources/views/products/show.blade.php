<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - KPMP Market</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <div class="text-sm font-medium text-gray-500">Detail Produk</div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        {{-- BAGIAN ATAS: DETAIL PRODUK (SRS-04) --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-0">
            
            {{-- KIRI: FOTO BESAR --}}
            <div class="bg-gray-100 p-8 flex items-center justify-center">
                @if($product->image_path)
                    <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="max-h-[500px] w-full object-contain rounded-lg shadow-lg {{ $product->stock == 0 ? 'grayscale opacity-75' : '' }}">
                @else
                    <div class="text-gray-400">Tidak ada gambar</div>
                @endif
            </div>

            {{-- KANAN: INFO PRODUK --}}
            <div class="p-8 flex flex-col">
                <span class="text-sm text-indigo-600 font-bold uppercase tracking-wide mb-2">{{ $product->category->name }}</span>
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $product->name }}</h1>
                
                {{-- Rating Bintang --}}
                <div class="flex items-center mb-6">
                    <div class="flex text-yellow-400">
                        @php $rating = round($product->reviews_avg_rating ?? 0); @endphp
                        @for($i=1; $i<=5; $i++)
                            <svg class="w-6 h-6 {{ $i <= $rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <span class="ml-2 text-gray-500 text-sm">({{ $product->reviews->count() }} Ulasan)</span>
                </div>

                <div class="text-4xl font-bold text-gray-900 mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

                <div class="mb-4">
                    <span class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-1 text-sm font-medium text-gray-700 border border-gray-200">
                        Stok Tersedia: <span class="ml-1 font-bold text-indigo-600">{{ $product->stock }}</span>
                    </span>
                </div>

                <div class="prose text-gray-600 mb-8">
                    <p>{{ $product->description }}</p>
                </div>

                {{-- Info Toko --}}
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200 mb-8">
                    <div class="bg-indigo-100 p-2 rounded-full">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">{{ $product->seller->store_name }}</p>
                        <p class="text-xs text-gray-500">{{ $product->seller->pic_city }}, {{ $product->seller->pic_province }}</p>
                    </div>
                </div>

                <div class="mt-auto">
                    @if($product->stock > 0)
                        <button class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl hover:bg-indigo-700 transition shadow-lg transform hover:-translate-y-1">
                            Beli Sekarang
                        </button>
                    @else
                        <button disabled class="w-full bg-gray-300 text-gray-500 font-bold py-4 rounded-xl cursor-not-allowed">
                            STOK HABIS
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- BAGIAN BAWAH: REVIEW & FORMULIR (SRS-06) --}}
        <div class="mt-12 grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- KOLOM KIRI: LIST REVIEW --}}
            <div class="lg:col-span-2">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Ulasan Pembeli</h3>
                @if($product->reviews->isEmpty())
                    <div class="bg-white p-8 rounded-xl text-center border border-dashed border-gray-300">
                        <p class="text-gray-500 italic">Belum ada ulasan. Jadilah yang pertama mereview produk ini!</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($product->reviews as $review)
                            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $review->visitor_name }}</p>
                                        <p class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex text-yellow-400 text-sm">
                                        @for($i=1; $i<=5; $i++)
                                            <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-700">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- KOLOM KANAN: FORMULIR INPUT REVIEW --}}
            <div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-lg sticky top-24">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Berikan Ulasan</h3>
                    <p class="text-sm text-gray-500 mb-4">Bagikan pengalaman Anda tentang produk ini.</p>

                    <form action="{{ route('review.store', $product->slug) }}" method="POST">
                        @csrf
                        
                        {{-- Data Diri (SRS-06 Wajib) --}}
                        <div class="space-y-3 mb-4">
                            <input type="text" name="visitor_name" placeholder="Nama Lengkap" class="w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            <input type="email" name="visitor_email" placeholder="Email (Untuk notifikasi)" class="w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                            <input type="text" name="visitor_phone" placeholder="Nomor HP" class="w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        {{-- Rating --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                            <select name="rating" class="w-full border-gray-300 rounded-lg text-sm">
                                <option value="5">⭐⭐⭐⭐⭐ (Sangat Bagus)</option>
                                <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                                <option value="3">⭐⭐⭐ (Cukup)</option>
                                <option value="2">⭐⭐ (Kurang)</option>
                                <option value="1">⭐ (Buruk)</option>
                            </select>
                        </div>

                        {{-- Komentar --}}
                        <div class="mb-4">
                            <textarea name="comment" rows="3" placeholder="Tulis komentar Anda..." class="w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500" required></textarea>
                        </div>

                        <button type="submit" class="w-full bg-gray-900 text-white font-bold py-3 rounded-lg hover:bg-gray-800 transition">
                            Kirim Ulasan
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- Script Popup --}}
    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#4F46E5',
                timer: 3000
            });
        @endif
        @if ($errors->any())
            Swal.fire({
                title: 'Gagal!',
                text: 'Mohon lengkapi formulir ulasan.',
                icon: 'error'
            });
        @endif
    </script>

</body>
</html>