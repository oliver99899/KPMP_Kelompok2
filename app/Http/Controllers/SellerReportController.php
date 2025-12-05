<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Product;
use App\Models\Seller;

class SellerReportController extends Controller
{
    /**
     * @param \Barryvdh\DomPDF\PDF $pdf Instance DomPDF yang sudah memuat view.
     * @param Request $request Objek Request dari HTTP.
     * @param string $filename Nama file default.
     * @return \Illuminate\Http\Response
     */
    protected function outputPdf(\Barryvdh\DomPDF\PDF $pdf, Request $request, string $filename, string $orientation = 'portrait')
    {
        // SRS 11: Set format laporan
        $pdf->setPaper('A4', $orientation);

        // SRS 10: Kontrol Output (Stream/Download)
        $action = $request->query('action', 'download'); 

        if (strtolower($action) === 'stream' || strtolower($action) === 'preview') {
            return $pdf->stream($filename);
        }
        return $pdf->download($filename);
    }
    
    /**
     * @return \App\Models\Seller|null
     */
    protected function getValidSeller()
    {
        $user = Auth::user();
        
        // Pengecekan 1: Pastikan user login dan perannya 'USER' (sesuai DB Anda)
        if (!$user || $user->role !== 'USER') {
            return null; // Bukan pengguna biasa atau tidak login (sudah ditangani middleware 'auth')
        }
        
        // Pengecekan 2: Pastikan ada relasi toko yang valid
        $seller = $user->seller;
        
        // Memastikan relasi tidak null dan merupakan instance dari Model Seller
        if ($seller instanceof \App\Models\Seller) {
            return $seller;
        }
        
        return null;
    }


    /**
     * [SRS-MartPlace-12] Laporan Stok Produk diurutkan berdasarkan stok menurun.
     */
    public function stockReportByStock(Request $request)
    {
        // Pengecekan otorisasi inti yang disederhanakan
        $seller = $this->getValidSeller();
        if (!$seller) {
            abort(403, 'Anda bukan akun penjual.');
        }
        $sellerId = $seller->id; // Aman diakses karena sudah dipastikan $seller adalah objek Model Seller

        // 1. Ambil data: Produk toko ini, diurutkan berdasarkan STOK MENURUN (SRS 12)
        $data = Product::where('seller_id', $sellerId)
            ->with('category')
            ->withAvg('reviews', 'rating')
            ->orderBy('stock', 'desc') // Kriteria: Stok Menurun
            ->get();
        
        $date = now()->format('d F Y H:i:s');
        $processor = Auth::user()->name;

        // Load view (SRS 9)
        $pdf = Pdf::loadView('reports.seller.stock_by_stock', compact('data', 'date', 'processor', 'seller'));
        
        $filename = 'Laporan_Stok_Menurun.pdf';
        
        // Output (SRS 10 & 11 - menggunakan Landscape untuk detail)
        return $this->outputPdf($pdf, $request, $filename, 'landscape');
    }

    /**
     * [SRS-MartPlace-13] Laporan Stok Produk diurutkan berdasarkan rating menurun.
     */
    public function stockReportByRating(Request $request)
    {
        // Pengecekan otorisasi inti
        $seller = $this->getValidSeller();
        if (!$seller) {
            abort(403, 'Anda bukan akun penjual.');
        }
        $sellerId = $seller->id;

        // 1. Ambil data: Produk toko ini, diurutkan berdasarkan RATING MENURUN (SRS 13)
        $data = Product::where('seller_id', $sellerId)
            ->with('category')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating') // Kriteria: Rating Menurun
            ->get();
        
        $date = now()->format('d F Y H:i:s');
        $processor = Auth::user()->name;

        // Load view (SRS 9)
        $pdf = Pdf::loadView('reports.seller.stock_by_rating', compact('data', 'date', 'processor', 'seller'));
        
        $filename = 'Laporan_Stok_Rating.pdf';
        
        // Output (SRS 10 & 11 - menggunakan Landscape untuk detail)
        return $this->outputPdf($pdf, $request, $filename, 'landscape');
    }

    /**
     * [SRS-MartPlace-14] Laporan Stok Produk yang harus segera di pesan (Stok < 2).
     */
    public function stockReportUrgent(Request $request)
    {
        // Pengecekan otorisasi inti
        $seller = $this->getValidSeller();
        if (!$seller) {
            abort(403, 'Anda bukan akun penjual.');
        }
        $sellerId = $seller->id;

        // 1. Ambil data: Produk toko ini yang STOKNYA KURANG DARI 2 (SRS 14)
        $data = Product::where('seller_id', $sellerId)
            ->with('category')
            ->withAvg('reviews', 'rating')
            ->where('stock', '<', 2) // Kriteria: Stok < 2
            ->orderBy('stock', 'asc')
            ->get();
        
        $date = now()->format('d F Y H:i:s');
        $processor = Auth::user()->name;

        // Load view (SRS 9)
        $pdf = Pdf::loadView('reports.seller.stock_urgent', compact('data', 'date', 'processor', 'seller'));
        
        $filename = 'Laporan_Stok_Mendesak.pdf';
        
        // Output (SRS 10 & 11 - menggunakan Portrait)
        return $this->outputPdf($pdf, $request, $filename, 'portrait');
    }
}