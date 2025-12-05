<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'ADMIN';
        $isSeller = false;
        if ($user->role === 'USER') {
            // Memastikan relasi seller ada dan mengembalikan Model Seller
            $isSeller = $user->seller instanceof \App\Models\Seller;
        }
        return view('dashboard', compact('isAdmin', 'isSeller')); 
    }

// --- SRS-07: DATA PLATFORM (ADMIN) ---
    public function platformData()
    {
        if (Auth::user()->role !== 'ADMIN') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // 1. Sebaran Produk per Kategori
        $productByCategory = Product::select('categories.name', DB::raw('count(products.id) as total'))
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('categories.name')
            ->pluck('total', 'name');

        // 2. Status Penjual Aktif/Tidak Aktif
        $sellerStatus = Seller::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
            
        // 3. JUMLAH PENGUNJUNG UNIK PEMBERI RATING (Diidentifikasi dari EMAIL UNIK)
        $uniqueReviewers = Review::distinct('visitor_email')->count('visitor_email');
        
        // 4. Jumlah Toko Berdasarkan Propinsi
        $sellerByProvince = Seller::select('pic_province', DB::raw('count(*) as total'))
            ->groupBy('pic_province')
            ->orderBy('total', 'desc')
            ->pluck('total', 'pic_province');
        
        return response()->json([
            'product_category' => $productByCategory,
            'seller_status' => $sellerStatus,
            'seller_province' => $sellerByProvince,
            'reviewers_count' => ['Pengunjung Unik' => $uniqueReviewers] // Data Baru
        ]);
    }

    // --- SRS-08: DATA PENJUAL (SELLER) ---
    public function sellerData()
    {
        $seller = Seller::where('user_id', Auth::id())->first();
        if (!$seller) return response()->json(['error' => 'Not a seller'], 403);
        
        $sellerId = $seller->id;

        // 1. Sebaran Stok per Produk
        $stockData = Product::where('seller_id', $sellerId)
            ->pluck('stock', 'name');

        // 2. Sebaran Rating per Produk
        $ratingData = Product::where('seller_id', $sellerId)
            ->withAvg('reviews', 'rating')
            ->pluck('reviews_avg_rating', 'name');

        // 3. Sebaran Pemberi Rating Berdasarkan Propinsi
        $reviewProvince = Review::select('pic_province', DB::raw('count(reviews.id) as total'))
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->where('products.seller_id', $sellerId)
            ->join('sellers', 'products.seller_id', '=', 'sellers.id') // Join ke tabel seller untuk ambil propinsi
            ->groupBy('pic_province')
            ->pluck('total', 'pic_province');

        return response()->json([
            'stock_data' => $stockData,
            'rating_data' => $ratingData,
            'review_province' => $reviewProvince
        ]);
    }
}