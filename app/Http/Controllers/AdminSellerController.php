<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Import Mail
use App\Mail\SellerApproved;         // Import Surat Terima
use App\Mail\SellerRejected;         // Import Surat Tolak

class AdminSellerController extends Controller
{
    // 1. Tampilkan Daftar Penjual
    public function index()
    {
        $pendingSellers = Seller::where('status', 'PENDING')->get();
        return view('admin.sellers.index', compact('pendingSellers'));
    }

    // 2. Logika Menyetujui (APPROVE) - DENGAN TRY-CATCH
    public function approve($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->update(['status' => 'ACTIVE']);

        // Coba kirim email, kalau gagal ya sudah (jangan crash)
        try {
            Mail::to($seller->pic_email)->send(new SellerApproved($seller));
        } catch (\Exception $e) {
            // Opsional: Log errornya biar kita tau
            // Log::error("Gagal kirim email approve: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Toko berhasil disetujui (Status: Active).');
    }

    // 3. Logika Menolak (REJECT) - DENGAN TRY-CATCH
    public function reject($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->update(['status' => 'REJECTED']);

        try {
            Mail::to($seller->pic_email)->send(new SellerRejected($seller));
        } catch (\Exception $e) {
            // Diam saja kalau error
        }

        return redirect()->back()->with('success', 'Toko telah ditolak.');
    }
}