<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewSubmitted;
use Illuminate\Support\Facades\Log; // Tambahkan Log

class ReviewController extends Controller
{
    public function store(Request $request, $slug)
    {
        // 1. Cek Produk
        $product = Product::where('slug', $slug)->firstOrFail();

        // 2. Validasi (Perhatikan nama field harus sama persis dengan di Form HTML)
        $validated = $request->validate([
            'visitor_name' => 'required|string|max:100',
            'visitor_email' => 'required|email|max:100',
            'visitor_phone' => 'required|string|max:20',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ], [
            // Pesan Error Bahasa Indonesia (PENTING AGAR SWEETALERT MUNCUL)
            'visitor_name.required' => 'Nama wajib diisi!',
            'visitor_email.required' => 'Email wajib diisi!',
            'visitor_email.email' => 'Format email salah!',
            'visitor_phone.required' => 'Nomor HP wajib diisi!',
            'rating.required' => 'Wajib pilih bintang 1-5!',
            'comment.required' => 'Komentar tidak boleh kosong!',
        ]);

        // 3. Simpan Review
        try {
            $review = Review::create([
                'product_id' => $product->id,
                'visitor_name' => $request->visitor_name,
                'visitor_email' => $request->visitor_email,
                'visitor_phone' => $request->visitor_phone,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
        } catch (\Exception $e) {
            // Jika database error
            return redirect()->back()->with('error', 'Gagal menyimpan ulasan ke database: ' . $e->getMessage());
        }

    // 4. KIRIM EMAIL (DENGAN PENGAMAN)
        try {
            Mail::to($request->visitor_email)->send(new ReviewSubmitted($review, $product));
        } catch (\Exception $e) {
            // Log error untuk Anda cek nanti
            \Log::error("Email gagal kirim: " . $e->getMessage());
            
            // Redirect dengan pesan SUKSES (karena review emang masuk), tapi kasih info kecil
            return redirect()->back()->with('success', 'Ulasan berhasil disimpan! (Email notifikasi tertunda karena gangguan koneksi)');
        }
        return redirect()->back()->with('success', 'Terima kasih! Ulasan dan notifikasi email berhasil dikirim.');
    }
}