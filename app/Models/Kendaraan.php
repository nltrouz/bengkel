<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Import model User

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraan';
    protected $primaryKey = 'nopol';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nopol', 'merek', 'tipe', 'transmisi', 'kapasitas', 'tahun', 'id_pelanggan'];
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'ktp');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pelanggan', 'nik_ktp');
    }
}
