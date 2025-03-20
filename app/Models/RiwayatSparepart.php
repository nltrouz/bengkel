<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatSparepart extends Model
{
    use HasFactory;

    protected $table = 'riwayat_sparepart';

    protected $fillable = [
        'riwayat_id',
        'kode_sparepart',
        'jumlah',
    ];

    public function riwayat()
    {
        return $this->belongsTo(Riwayat::class);
    }

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'kode_sparepart', 'kode');
    }
}
