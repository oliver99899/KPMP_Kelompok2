<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Mulai Berjualan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header Card --}}
            <div class="bg-indigo-600 rounded-t-xl p-8 text-center shadow-lg">
                <h3 class="text-2xl font-bold text-white">Formulir Pendaftaran Mitra</h3>
                <p class="text-indigo-100 mt-2 text-sm">Lengkapi data di bawah ini untuk membuka toko Anda di KPMP Market.</p>
            </div>

            <div class="bg-white overflow-hidden shadow-xl rounded-b-xl border border-t-0 border-gray-200">
                <div class="p-8">
                    <form method="POST" action="{{ route('seller.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- SECTION 1: PROFIL TOKO -->
                        <div class="mb-8">
                            <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4 flex items-center gap-2">
                                <span class="bg-indigo-100 text-indigo-600 w-6 h-6 rounded-full flex items-center justify-center text-xs">1</span>
                                Informasi Toko
                            </h4>
                            
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <x-input-label for="store_name" :value="__('Nama Toko')" class="text-gray-600" />
                                    <x-text-input id="store_name" class="block mt-1 w-full bg-gray-50 focus:bg-white transition" type="text" name="store_name" :value="old('store_name')" required placeholder="Contoh: Toko Berkah Jaya" />
                                    <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="store_description" :value="__('Deskripsi Singkat')" class="text-gray-600" />
                                    <textarea id="store_description" name="store_description" class="block mt-1 w-full bg-gray-50 focus:bg-white border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm transition h-24" placeholder="Jelaskan apa yang Anda jual...">{{ old('store_description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2: DATA PIC -->
                        <div class="mb-8">
                            <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4 flex items-center gap-2">
                                <span class="bg-indigo-100 text-indigo-600 w-6 h-6 rounded-full flex items-center justify-center text-xs">2</span>
                                Data Penanggung Jawab
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="pic_name" :value="__('Nama Lengkap (Sesuai KTP)')" />
                                    <x-text-input id="pic_name" class="block mt-1 w-full bg-gray-50" type="text" name="pic_name" :value="old('pic_name')" required />
                                </div>
                                <div>
                                    <x-input-label for="pic_phone" :value="__('No. WhatsApp / HP')" />
                                    <x-text-input id="pic_phone" class="block mt-1 w-full bg-gray-50" type="text" name="pic_phone" :value="old('pic_phone')" required placeholder="08..." />
                                </div>
                                <div class="md:col-span-2">
                                    <x-input-label for="pic_email" :value="__('Email PIC (Untuk Notifikasi)')" />
                                    <x-text-input id="pic_email" class="block mt-1 w-full bg-gray-50" type="email" name="pic_email" :value="old('pic_email')" required />
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: ALAMAT -->
                        <div class="mb-8">
                            <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4 flex items-center gap-2">
                                <span class="bg-indigo-100 text-indigo-600 w-6 h-6 rounded-full flex items-center justify-center text-xs">3</span>
                                Alamat Operasional
                            </h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="pic_street" :value="__('Jalan / Alamat Lengkap')" />
                                    <x-text-input id="pic_street" class="block mt-1 w-full bg-gray-50" type="text" name="pic_street" :value="old('pic_street')" required />
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="col-span-2">
                                        <x-input-label for="pic_city" :value="__('Kota/Kabupaten')" />
                                        <x-text-input id="pic_city" class="block mt-1 w-full bg-gray-50" type="text" name="pic_city" :value="old('pic_city')" required />
                                    </div>
                                    <div>
                                        <x-input-label for="pic_province" :value="__('Provinsi')" />
                                        <x-text-input id="pic_province" class="block mt-1 w-full bg-gray-50" type="text" name="pic_province" :value="old('pic_province')" required />
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <x-input-label for="pic_village" :value="__('Kelurahan')" />
                                        <x-text-input id="pic_village" class="block mt-1 w-full bg-gray-50" type="text" name="pic_village" :value="old('pic_village')" required />
                                    </div>
                                    <div>
                                        <x-input-label for="pic_rt" :value="__('RT')" />
                                        <x-text-input id="pic_rt" class="block mt-1 w-full bg-gray-50" type="text" name="pic_rt" :value="old('pic_rt')" required />
                                    </div>
                                    <div>
                                        <x-input-label for="pic_rw" :value="__('RW')" />
                                        <x-text-input id="pic_rw" class="block mt-1 w-full bg-gray-50" type="text" name="pic_rw" :value="old('pic_rw')" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 4: DOKUMEN -->
                        <div class="mb-8">
                            <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4 flex items-center gap-2">
                                <span class="bg-indigo-100 text-indigo-600 w-6 h-6 rounded-full flex items-center justify-center text-xs">4</span>
                                Dokumen Legalitas
                            </h4>

                            <div class="space-y-6">
                                <div>
                                    <x-input-label for="pic_ktp_number" :value="__('Nomor KTP (16 Digit)')" />
                                    <x-text-input id="pic_ktp_number" class="block mt-1 w-full bg-gray-50 tracking-widest font-mono" type="text" name="pic_ktp_number" :value="old('pic_ktp_number')" required maxlength="16" />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:bg-gray-50 transition relative">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <label for="pic_photo" class="block text-sm font-medium text-gray-700 mt-2 cursor-pointer">
                                            <span>Upload Foto Wajah</span>
                                            <input id="pic_photo" name="pic_photo" type="file" class="sr-only" required accept="image/*">
                                        </label>
                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG (Max 2MB)</p>
                                    </div>

                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:bg-gray-50 transition relative">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <label for="pic_ktp_file" class="block text-sm font-medium text-gray-700 mt-2 cursor-pointer">
                                            <span>Upload Scan KTP</span>
                                            <input id="pic_ktp_file" name="pic_ktp_file" type="file" class="sr-only" required accept=".pdf,image/*">
                                        </label>
                                        <p class="text-xs text-gray-500 mt-1">PDF, JPG (Max 5MB)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-6 border-t">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-6">Batal</a>
                            <button type="submit" class="bg-indigo-600 text-white font-bold py-3 px-8 rounded-lg shadow hover:bg-indigo-700 transition transform hover:-translate-y-0.5">
                                Ajukan Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>