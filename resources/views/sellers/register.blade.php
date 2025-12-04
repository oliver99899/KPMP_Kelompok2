<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrasi Penjual (Toko)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Form Registrasi --}}
                    {{-- PENTING: enctype="multipart/form-data" wajib ada untuk upload file --}}
                    <form method="POST" action="{{ route('seller.store') }}" enctype="multipart/form-data">
                        @csrf

                        <h3 class="text-lg font-bold mb-4 text-indigo-600">I. Data Toko</h3>
                        
                        <div class="mb-4">
                            <x-input-label for="store_name" :value="__('Nama Toko *')" />
                            <x-text-input id="store_name" class="block mt-1 w-full" type="text" name="store_name" :value="old('store_name')" required autofocus />
                            <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="store_description" :value="__('Deskripsi Singkat')" />
                            <textarea id="store_description" name="store_description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('store_description') }}</textarea>
                            <x-input-error :messages="$errors->get('store_description')" class="mt-2" />
                        </div>

                        <h3 class="text-lg font-bold mb-4 mt-8 text-indigo-600">II. Data Penanggung Jawab (PIC)</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <x-input-label for="pic_name" :value="__('Nama Lengkap PIC *')" />
                                <x-text-input id="pic_name" class="block mt-1 w-full" type="text" name="pic_name" :value="old('pic_name')" required />
                                <x-input-error :messages="$errors->get('pic_name')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="pic_phone" :value="__('No. Handphone PIC *')" />
                                <x-text-input id="pic_phone" class="block mt-1 w-full" type="text" name="pic_phone" :value="old('pic_phone')" required />
                            </div>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="pic_email" :value="__('Email PIC (Untuk Notifikasi) *')" />
                            <x-text-input id="pic_email" class="block mt-1 w-full" type="email" name="pic_email" :value="old('pic_email')" required />
                            <x-input-error :messages="$errors->get('pic_email')" class="mt-2" />
                        </div>

                        <h3 class="text-lg font-bold mb-4 mt-8 text-indigo-600">III. Alamat PIC</h3>
                        
                        <div class="mb-4">
                            <x-input-label for="pic_street" :value="__('Jalan / Alamat Lengkap *')" />
                            <x-text-input id="pic_street" class="block mt-1 w-full" type="text" name="pic_street" :value="old('pic_street')" required />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <x-input-label for="pic_rt" :value="__('RT *')" />
                                <x-text-input id="pic_rt" class="block mt-1 w-full" type="text" name="pic_rt" :value="old('pic_rt')" required />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="pic_rw" :value="__('RW *')" />
                                <x-text-input id="pic_rw" class="block mt-1 w-full" type="text" name="pic_rw" :value="old('pic_rw')" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="mb-4">
                                <x-input-label for="pic_village" :value="__('Kelurahan *')" />
                                <x-text-input id="pic_village" class="block mt-1 w-full" type="text" name="pic_village" :value="old('pic_village')" required />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="pic_city" :value="__('Kabupaten / Kota *')" />
                                <x-text-input id="pic_city" class="block mt-1 w-full" type="text" name="pic_city" :value="old('pic_city')" required />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="pic_province" :value="__('Propinsi *')" />
                                <x-text-input id="pic_province" class="block mt-1 w-full" type="text" name="pic_province" :value="old('pic_province')" required />
                            </div>
                        </div>

                        <h3 class="text-lg font-bold mb-4 mt-8 text-indigo-600">IV. Dokumen Identitas</h3>

                        <div class="mb-4">
                            <x-input-label for="pic_ktp_number" :value="__('Nomor KTP (16 Digit) *')" />
                            <x-text-input id="pic_ktp_number" class="block mt-1 w-full" type="text" name="pic_ktp_number" :value="old('pic_ktp_number')" required maxlength="16" />
                            <x-input-error :messages="$errors->get('pic_ktp_number')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="pic_photo" :value="__('Foto PIC (Wajah) - Max 2MB *')" />
                            <input id="pic_photo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-2" type="file" name="pic_photo" accept="image/*" required>
                            <x-input-error :messages="$errors->get('pic_photo')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="pic_ktp_file" :value="__('Scan KTP (PDF/JPG) - Max 5MB *')" />
                            <input id="pic_ktp_file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-2" type="file" name="pic_ktp_file" accept=".pdf,image/*" required>
                            <x-input-error :messages="$errors->get('pic_ktp_file')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <x-primary-button class="ml-4">
                                {{ __('Daftar Sekarang') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>