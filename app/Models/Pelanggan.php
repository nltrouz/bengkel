<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan'; // Nama tabel di database

    protected $primaryKey = 'ktp'; // Primary Key

    public $incrementing = false; // Karena primary key bukan auto-increment

    protected $keyType = 'string'; // Tipe data primary key

    protected $fillable = ['ktp', 'nama', 'alamat', 'hp'];

    public function kendaraan()
{
    return $this->hasMany(Kendaraan::class, 'id_pelanggan', 'ktp');
}

public function riwayats()
{
    return $this->hasMany(Riwayat::class, 'ktp_pelanggan', 'ktp');
}

}
