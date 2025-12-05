<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Verifikasi Penjual') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-gray-900 text-xl">Daftar Pengajuan Toko (Pending)</h3>

                    {{-- DROPDOWN DOWNLOAD LAPORAN (SRS 09-11) --}}
                    <div x-data="{ open: false }" class="relative inline-block text-left">
                        <button type="button" @click="open = !open" class="inline-flex justify-center w-full rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-indigo-600 text-sm font-bold text-white hover:bg-indigo-700 focus:outline-none transition">
                            Download Laporan Platform (PDF)
                            <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>

                        <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-60 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-20">
                            <div class="py-1">
                                <a href="{{ route('report.platform.status') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" target="_blank" @click="open = false">
                                    1. Akun Penjual (Status)
                                </a>
                                <a href="{{ route('report.platform.location') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" target="_blank" @click="open = false">
                                    2. Toko per Lokasi (Propinsi)
                                </a>
                                <a href="{{ route('report.platform.rating') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" target="_blank" @click="open = false">
                                    3. Produk Berdasarkan Rating
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

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
                                                <form action="{{ route('admin.sellers.approve', $seller->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menyetujui toko ini?');">
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
</x-app-layout>