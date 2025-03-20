<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;
    protected $table = 'sparepart';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $fillable = ['kode', 'nama', 'jumlah', 'harga'];

    public function riwayats()
    {
        return $this->belongsToMany(Riwayat::class, 'riwayat_sparepart', 'kode_sparepart', 'riwayat_id')
                    ->withPivot('jumlah')
                    ->withTimestamps();
    }

}
