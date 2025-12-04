<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke User Login (Opsional tapi disarankan agar akun login terhubung dengan data toko)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 1. Nama Toko & Deskripsi [cite: 27-28]
            $table->string('store_name'); 
            $table->text('store_description')->nullable(); 

            // 2. Data Personal PIC (Person In Charge) [cite: 29, 30, 32]
            $table->string('pic_name'); 
            $table->string('pic_phone'); 
            $table->string('pic_email'); // Email khusus korespondensi toko

            // 3. Alamat Lengkap PIC [cite: 33, 35-39]
            $table->string('pic_street');   // Jalan
            $table->string('pic_rt', 5);    // RT
            $table->string('pic_rw', 5);    // RW
            $table->string('pic_village');  // Kelurahan
            $table->string('pic_city');     // Kabupaten/Kota
            $table->string('pic_province'); // Propinsi

            // 4. Dokumen Identitas [cite: 40-42]
            $table->string('pic_ktp_number', 16); // No KTP
            $table->string('pic_photo_path')->nullable(); // Foto PIC
            $table->string('pic_ktp_file_path')->nullable(); // File Scan KTP

            // 5. Status Verifikasi (Enum sesuai Diagram) [cite: 111-113]
            // Default PENDING agar diverifikasi admin dulu
            $table->enum('status', ['PENDING', 'ACTIVE', 'REJECTED'])->default('PENDING');

            $table->timestamps(); // CreatedAt & UpdatedAt
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};