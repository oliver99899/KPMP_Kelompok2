<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional jika sesuai standar, tapi aman ditulis)
    protected $table = 'sellers';

    // DAFTAR KOLOM YANG BOLEH DIISI (Mass Assignment)
    protected $fillable = [
        'user_id',
        'store_name',
        'store_description',
        'pic_name',
        'pic_email',
        'pic_phone',
        'pic_street',
        'pic_rt',
        'pic_rw',
        'pic_village',
        'pic_city',
        'pic_province',
        'pic_ktp_number',
        'pic_photo_path',
        'pic_ktp_file_path',
        'status',
    ];

    // Relasi: Penjual milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}