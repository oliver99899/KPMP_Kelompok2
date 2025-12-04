<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    // Menampilkan Formulir Registrasi (Method: create) [cite: 277]
    public function create()
    {
        // Cek apakah user sudah pernah daftar toko? Jika sudah, jangan kasih daftar lagi.
        if (Seller::where('user_id', Auth::id())->exists()) {
            return redirect()->route('dashboard')->with('error', 'Anda sudah terdaftar sebagai penjual.');
        }

        return view('sellers.register');
    }

    // Menyimpan Data Registrasi (Method: store) [cite: 278]
    public function store(Request $request)
    {
        // 1. Validasi Input sesuai SRS & Quick Design [cite: 229]
        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string',
            'pic_name' => 'required|string|max:255',
            'pic_email' => 'required|email|max:255',
            'pic_phone' => 'required|string|max:20',
            'pic_street' => 'required|string',
            'pic_rt' => 'required|string|max:5',
            'pic_rw' => 'required|string|max:5',
            'pic_village' => 'required|string',
            'pic_city' => 'required|string',
            'pic_province' => 'required|string',
            'pic_ktp_number' => 'required|string|size:16', // KTP harus 16 digit
            // Validasi File: Foto JPG/PNG max 2MB [cite: 199]
            'pic_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', 
            // Validasi File: KTP JPG/PNG/PDF max 5MB [cite: 202]
            'pic_ktp_file' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120', 
        ]);

        // 2. Proses Upload File
        $photoPath = $request->file('pic_photo')->store('seller_photos', 'public');
        $ktpPath = $request->file('pic_ktp_file')->store('seller_ktps', 'public');

        // 3. Simpan ke Database (Model Seller) [cite: 271]
        Seller::create([
            'user_id' => Auth::id(), // Ambil ID user yang sedang login
            'store_name' => $request->store_name,
            'store_description' => $request->store_description,
            'pic_name' => $request->pic_name,
            'pic_email' => $request->pic_email,
            'pic_phone' => $request->pic_phone,
            'pic_street' => $request->pic_street,
            'pic_rt' => $request->pic_rt,
            'pic_rw' => $request->pic_rw,
            'pic_village' => $request->pic_village,
            'pic_city' => $request->pic_city,
            'pic_province' => $request->pic_province,
            'pic_ktp_number' => $request->pic_ktp_number,
            'pic_photo_path' => $photoPath,
            'pic_ktp_file_path' => $ktpPath,
            'status' => 'PENDING', // Status awal Pending
        ]);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Registrasi toko berhasil! Mohon tunggu verifikasi admin.');
    }
}