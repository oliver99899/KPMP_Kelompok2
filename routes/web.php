<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;     // Controller Penjual (SRS-01)
use App\Http\Controllers\AdminSellerController;   // Controller Admin (SRS-02)
use App\Http\Controllers\DashboardController;    // Controller Dashboard (SRS-07/08)
use App\Http\Controllers\HomeController;      // Controller Halaman Depan (SRS-04/05)
use App\Http\Controllers\ReviewController;     // Controller Review (SRS-06)
use App\Http\Controllers\ReportController;     // Controller Laporam Platform (SRS-09/10/11)
use App\Http\Controllers\SellerReportController;  // [PENTING] Import SellerReportController (SRS 12-14)
use App\Http\Middleware\IsAdmin;          // Middleware Admin
use Illuminate\Support\Facades\Route;

// --- RUTE PUBLIK (PENGUNJUNG) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [HomeController::class, 'show'])->name('product.show');
Route::post('/product/{slug}/review', [ReviewController::class, 'store'])->name('review.store');
Route::get('/store/{id}', [HomeController::class, 'storeDetail'])->name('store.show');


// --- GRUP RUTE UNTUK USER LOGIN (Wajib Autentikasi) ---
Route::middleware('auth')->group(function () {
  
  // 1. RUTE DASHBOARD (Wajib Login & Verifikasi Email)
  Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['verified'])->name('dashboard');

  // 2. A. Manajemen Profil (Bawaan Breeze)
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  // 2. B. RUTE PENJUAL (SRS-01: Registrasi Toko)
  Route::get('/seller/register', [SellerController::class, 'create'])->name('seller.register');
  Route::post('/seller/register', [SellerController::class, 'store'])->name('seller.store');

  // 2. C. RUTE KHUSUS ADMIN (SRS-02: Verifikasi Toko & Laporan Platform)
  Route::middleware([IsAdmin::class])->group(function () {
    // Halaman List Verifikasi
    Route::get('/admin/sellers', [AdminSellerController::class, 'index'])->name('admin.sellers.index');
    // Aksi Terima (Approve)
    Route::post('/admin/sellers/{id}/approve', [AdminSellerController::class, 'approve'])->name('admin.sellers.approve');
    // Aksi Tolak (Reject)
    Route::post('/admin/sellers/{id}/reject', [AdminSellerController::class, 'reject'])->name('admin.sellers.reject');
    
        // --- [DITAMBAHKAN KEMBALI] RUTE LAPORAN PLATFORM (SRS 09-11) ---
    Route::get('/admin/report/status', [ReportController::class, 'sellerStatusReport'])->name('report.platform.status');
    Route::get('/admin/report/location', [ReportController::class, 'storeLocationReport'])->name('report.platform.location');
    Route::get('/admin/report/rating', [ReportController::class, 'productRatingReport'])->name('report.platform.rating');
  });

    // 2. D. RUTE KHUSUS PENJUAL (SRS 12-14)
    // Grup ini hanya memastikan pengguna terautentikasi dan terverifikasi. Otorisasi Seller ada di Controller.
    // Catatan: Jika Anda tetap mengalami 404, coba ganti 'verified' dengan 'auth'.
    Route::group(['middleware' => 'verified'], function () { 
        // --- [DITAMBAHKAN KEMBALI] RUTE LAPORAN STOK PENJUAL (SRS 12-14) ---
        // SRS-MartPlace-12: Stok Menurun
        Route::get('/seller/reports/stock/by-stock', [SellerReportController::class, 'stockReportByStock'])->name('seller.report.stock.by_stock');
        
        // SRS-MartPlace-13: Rating Menurun
        Route::get('/seller/reports/stock/by-rating', [SellerReportController::class, 'stockReportByRating'])->name('seller.report.stock.by_rating');

        // SRS-MartPlace-14: Stok Mendesak (< 2)
        Route::get('/seller/reports/stock/urgent', [SellerReportController::class, 'stockReportUrgent'])->name('seller.report.stock.urgent');
    });


  // 2. E. MANAJEMEN PRODUK (SRS-03)
  Route::resource('products', \App\Http\Controllers\ProductController::class);

  // 2. F. API DATA UNTUK CHART (SRS-07 & SRS-08)
  Route::get('/api/dashboard/platform', [DashboardController::class, 'platformData'])->name('api.dashboard.platform');
  Route::get('/api/dashboard/seller', [DashboardController::class, 'sellerData'])->name('api.dashboard.seller');
});

// --- RUTE OTENTIKASI (Login, Register, Logout) ---
require __DIR__.'/auth.php';