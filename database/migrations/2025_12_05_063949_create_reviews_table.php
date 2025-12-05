<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Relasi ke Produk
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            // Data Pengunjung (Wajib isi sesuai SRS-06)
            $table->string('visitor_name');
            $table->string('visitor_email');
            $table->string('visitor_phone');
            
            // Isi Review
            $table->integer('rating'); // 1 sampai 5
            $table->text('comment');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};