<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Halaman Verifikasi Penjual') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-lg font-bold mb-4">Daftar Pengajuan Toko Baru (Pending)</h3>

                    @if($pendingSellers->isEmpty())
                        <div class="p-4 bg-yellow-50 text-yellow-700 rounded-lg">
                            Belum ada pendaftaran toko baru yang perlu diverifikasi.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-3 px-6 text-left">No</th>
                                        <th class="py-3 px-6 text-left">Nama Toko</th>
                                        <th class="py-3 px-6 text-left">Data PIC</th>
                                        <th class="py-3 px-6 text-center">Dokumen</th>
                                        <th class="py-3 px-6 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach($pendingSellers as $index => $seller)
                                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <span class="font-bold">{{ $seller->store_name }}</span>
                                                <br>
                                                <span class="text-xs text-gray-500">Status: {{ $seller->status }}</span>
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <p><strong>Nama:</strong> {{ $seller->pic_name }}</p>
                                                <p><strong>Email:</strong> {{ $seller->pic_email }}</p>
                                                <p><strong>HP:</strong> {{ $seller->pic_phone }}</p>
                                                <p class="text-xs mt-1 text-gray-500">{{ $seller->pic_city }}, {{ $seller->pic_province }}</p>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                {{-- Link Lihat KTP --}}
                                                <a href="{{ asset('storage/'.$seller->pic_ktp_file_path) }}" target="_blank" class="bg-blue-100 text-blue-600 py-1 px-3 rounded-full text-xs font-bold hover:bg-blue-200">
                                                    Lihat KTP
                                                </a>
                                                <br>
                                                <a href="{{ asset('storage/'.$seller->pic_photo_path) }}" target="_blank" class="text-xs text-blue-500 underline mt-2 inline-block">
                                                    Lihat Foto Wajah
                                                </a>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex item-center justify-center gap-2">
                                                    
                                                    {{-- Tombol TERIMA (Approve) --}}
                                                    <form action="{{ route('admin.sellers.approve', $seller->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menyetujui toko ini? Email notifikasi akan dikirim.');">
                                                        @csrf
                                                        <button type="submit" class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center hover:bg-green-200" title="Terima / Approve">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    {{-- Tombol TOLAK (Reject) --}}
                                                    <form action="{{ route('admin.sellers.reject', $seller->id) }}" method="POST" onsubmit="return confirm('Yakin ingin MENOLAK toko ini?');">
                                                        @csrf
                                                        <button type="submit" class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-200" title="Tolak / Reject">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>