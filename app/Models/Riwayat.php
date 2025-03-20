<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sparepart;
use App\Models\JasaServis;

class Riwayat extends Model
{
    use HasFactory;

    protected $table = 'riwayat'; // Nama tabel di database
    protected $fillable = [
        'tanggal', 
        'keluhan', 
        'penanganan', 
        'catatan', 
        'id_karyawan', 
        'nopol', 
        'id_jasa', 
        'kode_sparepart', 
        'ktp_pelanggan', 
        'status',
        'total_harga'
    ];

    // Relasi ke Karyawan (Satu Riwayat ditangani oleh satu Karyawan)
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    // Relasi ke Booking (Bisa menggunakan nomor polisi untuk menghubungkan ke kendaraan)
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'nopol', 'nopol');
    }

    // Relasi ke Jasa Servis
    public function jasaServis()
    {
        return $this->belongsTo(JasaServis::class, 'id_jasa', 'id');
    }

    // Relasi ke Sparepart (Many-to-Many)
    public function spareparts()
    {
        return $this->belongsToMany(Sparepart::class, 'riwayat_sparepart', 'riwayat_id', 'kode_sparepart')
                    ->withPivot('jumlah')
                    ->withTimestamps();
    }

    // Relasi ke Pelanggan berdasarkan KTP
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'ktp_pelanggan', 'ktp');
    }

    // Accessor untuk menghitung total harga (Jasa Servis + Sparepart)
    public function getTotalHargaAttribute()
{
    // Pastikan sparepart tidak null sebelum diproses
    $totalSparepart = $this->spareparts ? $this->spareparts->sum(function ($sparepart) {
        return $sparepart->harga * ($sparepart->pivot->jumlah ?? 1);
    }) : 0;

    // Ambil harga jasa servis
    $hargaJasa = $this->jasaServis ? $this->jasaServis->harga : 0;

    return $totalSparepart + $hargaJasa;
}

}
