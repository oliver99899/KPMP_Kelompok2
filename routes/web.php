<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;      // Controller Penjual (SRS-01)
use App\Http\Controllers\AdminSellerController; // Controller Admin (SRS-02)
use App\Http\Middleware\IsAdmin;                // Middleware Admin (Solusi Error Closure)
use Illuminate\Support\Facades\Route;

// --- RUTE PUBLIK (PENGUNJUNG) ---
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/product/{slug}', [\App\Http\Controllers\HomeController::class, 'show'])->name('product.show');
Route::post('/product/{slug}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');

// --- 2. RUTE DASHBOARD (Perlu Login & Verifikasi Email) ---
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- 3. GRUP RUTE UNTUK USER LOGIN ---
Route::middleware('auth')->group(function () {
    
    // A. Manajemen Profil (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // B. RUTE PENJUAL (SRS-01: Registrasi Toko)
    Route::get('/seller/register', [SellerController::class, 'create'])->name('seller.register');
    Route::post('/seller/register', [SellerController::class, 'store'])->name('seller.store');

    // C. RUTE KHUSUS ADMIN (SRS-02: Verifikasi Toko)
    // Menggunakan Class Middleware 'IsAdmin' yang baru dibuat
    Route::middleware([IsAdmin::class])->group(function () {
        
        // Halaman List Verifikasi
        Route::get('/admin/sellers', [AdminSellerController::class, 'index'])->name('admin.sellers.index');
        
        // Aksi Terima (Approve)
        Route::post('/admin/sellers/{id}/approve', [AdminSellerController::class, 'approve'])->name('admin.sellers.approve');
        
        // Aksi Tolak (Reject)
        Route::post('/admin/sellers/{id}/reject', [AdminSellerController::class, 'reject'])->name('admin.sellers.reject');
    });
    // D. MANAJEMEN PRODUK (SRS-03) ---
    // Resource route otomatis membuat rute index, create, store, edit, update, destroy
    Route::resource('products', \App\Http\Controllers\ProductController::class);
});

// --- 4. RUTE OTENTIKASI (Login, Register, Logout) ---
require __DIR__.'/auth.php';