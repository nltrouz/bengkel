<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Karyawan;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $primaryKey = 'no_urut';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nik', 'tanggal_booking', 'tanggal_penanganan', 'waktu_datang', 'status',
        'no_antrian_per_hari', 'nopol', 'merek', 'tipe', 'transmisi', 'kapasitas', 'tahun', 'keluhan'
    ];    

    /**
     * Relasi ke tabel pelanggan
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'nik', 'ktp');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

}
