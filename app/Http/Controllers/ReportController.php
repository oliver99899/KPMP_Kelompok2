<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Metode pembantu untuk menangani output PDF (Stream/Download) dan SRS-11 (Kustomisasi Format).
     *
     * @param \Barryvdh\DomPDF\PDF $pdf Instance DomPDF yang sudah memuat view.
     * @param Request $request Objek Request dari HTTP.
     * @param string $filename Nama file default.
     * @return \Illuminate\Http\Response
     */
    protected function outputPdf(\Barryvdh\DomPDF\PDF $pdf, Request $request, string $filename)
    {
        // --- REALISASI SRS 11 (Kustomisasi Format: A4 Portrait) ---
        $pdf->setPaper('A4', 'portrait');

        // --- REALISASI SRS 10 (Kontrol Output) ---
        // Cek apakah ada parameter 'action=stream' atau 'action=preview' dari URL
        $action = $request->query('action', 'download'); 

        if (strtolower($action) === 'stream' || strtolower($action) === 'preview') {
            // Stream: Menampilkan di browser (Pratinjau)
            return $pdf->stream($filename);
        }

        // Default: Download file
        return $pdf->download($filename);
    }

    // --- SRS-09: LAPORAN AKUN PENJUAL BERDASARKAN STATUS ---
    public function sellerStatusReport(Request $request)
    {
        if (Auth::user()->role !== 'ADMIN') abort(403, 'Akses Ditolak.');

        // 1. Ambil data: Gabungkan User dan Seller, lalu urutkan sesuai permintaan (SRS 09)
        $data = User::select('users.name as user_name', 'sellers.pic_name', 'sellers.store_name', 'sellers.status', 'sellers.created_at as created_at')
            ->join('sellers', 'users.id', '=', 'sellers.user_id')
            ->whereIn('sellers.status', ['ACTIVE', 'REJECTED', 'PENDING'])
            ->orderByRaw("FIELD(sellers.status, 'ACTIVE', 'PENDING', 'REJECTED')") // Mengurutkan ACTIVE dulu
            ->get();
        
        $date = now()->format('d F Y H:i:s');
        $processor = Auth::user()->name;

        // Load view (SRS 09)
        $pdf = Pdf::loadView('reports.platforms.seller_status', compact('data', 'date', 'processor')); // DIPERBAIKI: reports.platforms.seller_status
        
        $filename = 'Laporan_Akun_Penjual_Status.pdf';
        
        // Output (SRS 10 & 11)
        return $this->outputPdf($pdf, $request, $filename);
    }

    // --- SRS-10: LAPORAN DAFTAR TOKO BERDASARKAN PROPINSI ---
    public function storeLocationReport(Request $request)
    {
        if (Auth::user()->role !== 'ADMIN') abort(403, 'Akses Ditolak.');

        // Ambil data Seller aktif dan urutkan berdasarkan Propinsi (SRS 10)
        $data = Seller::select('store_name', 'pic_name', 'pic_province', 'created_at as registration_date')
            ->where('status', 'ACTIVE')
            ->orderBy('pic_province', 'asc')
            ->get();
        
        $date = now()->format('d F Y H:i:s');
        $processor = Auth::user()->name;

        // Load view
        $pdf = Pdf::loadView('reports.platforms.store_location', compact('data', 'date', 'processor')); // DIPERBAIKI: reports.platforms.store_location
        
        $filename = 'Laporan_Toko_Lokasi.pdf';

        // Output (SRS 10 & 11)
        return $this->outputPdf($pdf, $request, $filename);
    }

    // --- SRS-11: LAPORAN DAFTAR PRODUK BERDASARKAN RATING ---
    public function productRatingReport(Request $request)
    {
        if (Auth::user()->role !== 'ADMIN') abort(403, 'Akses Ditolak.');

        // Ambil Produk, hitung rata-rata rating, dan urutkan (SRS 11)
        $data = Product::select('products.name as product_name', 'categories.name as category_name', 'products.price', 'sellers.store_name', 'sellers.pic_province')
            ->withAvg('reviews', 'rating')
            ->join('sellers', 'products.seller_id', '=', 'sellers.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->having('reviews_avg_rating', '>', 0) // Hanya tampilkan yang punya rating
            ->orderByDesc('reviews_avg_rating')
            ->get();
            
        // Catatan: Propinsi Toko digunakan sebagai ganti Propinsi Pemberi Rating.
        
        $date = now()->format('d F Y H:i:s');
        $processor = Auth::user()->name;

        // Load view
        $pdf = Pdf::loadView('reports.platforms.product_rating', compact('data', 'date', 'processor')); // DIPERBAIKI: reports.platforms.product_rating
        
        $filename = 'Laporan_Produk_Rating.pdf';
        
        // Output (SRS 10 & 11)
        return $this->outputPdf($pdf, $request, $filename);
    }
}