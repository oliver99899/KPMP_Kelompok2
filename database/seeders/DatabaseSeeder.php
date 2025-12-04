<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Admin Platform',
            'email' => 'admin@kpmp.com',
            'password' => Hash::make('admin123'),
            'role' => 'ADMIN', // Pastikan kolom ini sudah ada di database
        ]);

        // 2. Buat Akun User Biasa (Dummy) - Opsional buat ngetes
        User::create([
            'name' => 'User Penjual',
            'email' => 'penjual@kpmp.com',
            'password' => Hash::make('password'),
            'role' => 'USER',
        ]);
    }
}