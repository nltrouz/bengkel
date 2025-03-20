<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Aktivitas extends Model
{
    use HasFactory;

    protected $table = 'aktivitas'; // Nama tabel

    protected $fillable = ['user_id', 'aksi', 'deskripsi', 'created_at'];

    public $timestamps = true;

    // Properti casts untuk konversi otomatis ke datetime
    protected $casts = [
        'created_at' => 'datetime',
    ];
}
