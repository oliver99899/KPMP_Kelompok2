<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController; // <--- PENTING: Jangan lupa ini!
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- RUTE PENJUAL (Ditaruh di sini agar aman terproteksi login) ---
    Route::get('/seller/register', [SellerController::class, 'create'])->name('seller.register');
    Route::post('/seller/register', [SellerController::class, 'store'])->name('seller.store');
});

// Baris ini memanggil rute Login/Register bawaan Breeze
require __DIR__.'/auth.php';