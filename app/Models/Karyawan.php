<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan'; // Nama tabel di database
    protected $fillable = ['nama', 'alamat', 'hp']; // Kolom yang bisa diisi

    // Relasi ke tabel Riwayat (Seorang karyawan bisa menangani banyak riwayat servis)
    public function riwayat()
    {
        return $this->hasMany(Riwayat::class, 'id_karyawan');
    }
}
