<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    // Menampilkan Formulir Registrasi (Atau Edit jika Ditolak)
    public function create()
    {
        $seller = Seller::where('user_id', Auth::id())->first();

        // Jika sudah punya toko
        if ($seller) {
            // Jika AKTIF atau PENDING, jangan kasih daftar lagi
            if ($seller->status === 'ACTIVE' || $seller->status === 'PENDING') {
                return redirect()->route('dashboard')->with('error', 'Anda sudah terdaftar atau sedang dalam verifikasi.');
            }
            // Jika REJECTED, boleh lanjut ke view (untuk perbaikan)
        }

        // Kirim data $seller ke view (bisa null jika pengguna baru, atau berisi data jika ditolak)
        return view('sellers.register', compact('seller'));
    }

    // Menyimpan Data Registrasi (Create / Update)
    public function store(Request $request)
    {
        // Cek apakah ini update data lama (Re-Apply) atau baru
        $seller = Seller::where('user_id', Auth::id())->first();

        $rules = [
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
            'pic_ktp_number' => 'required|string|size:16',
            // File wajib jika baru, opsional jika update (nullable)
            'pic_photo' => $seller ? 'nullable|image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048',
            'pic_ktp_file' => $seller ? 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120' : 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ];

        $request->validate($rules);

        // Siapkan data untuk disimpan
        $data = [
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
            'status' => 'PENDING', // Reset status jadi PENDING agar dicek admin lagi
        ];

        // Handle File Upload (Hanya jika ada file baru)
        if ($request->hasFile('pic_photo')) {
            if ($seller && $seller->pic_photo_path) Storage::disk('public')->delete($seller->pic_photo_path);
            $data['pic_photo_path'] = $request->file('pic_photo')->store('seller_photos', 'public');
        }
        
        if ($request->hasFile('pic_ktp_file')) {
            if ($seller && $seller->pic_ktp_file_path) Storage::disk('public')->delete($seller->pic_ktp_file_path);
            $data['pic_ktp_file_path'] = $request->file('pic_ktp_file')->store('seller_ktps', 'public');
        }

        if ($seller) {
            // UPDATE data lama
            $seller->update($data);
            $message = 'Pengajuan ulang berhasil dikirim! Mohon tunggu verifikasi admin.';
        } else {
            // CREATE data baru
            $data['user_id'] = Auth::id();
            Seller::create($data);
            $message = 'Registrasi toko berhasil! Mohon tunggu verifikasi admin.';
        }

        return redirect()->route('dashboard')->with('success', $message);
    }
}