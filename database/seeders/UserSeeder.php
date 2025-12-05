<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Admin Platform',
            'email' => 'admin@kpmp.com',
            'password' => Hash::make('admin123'),
            'role' => 'ADMIN',
        ]);

        // 2. Buat Akun User Penjual (Dummy)
        User::create([
            'name' => 'User Penjual',
            'email' => 'penjual@kpmp.com',
            'password' => Hash::make('password'),
            'role' => 'USER',
        ]);
    }
}