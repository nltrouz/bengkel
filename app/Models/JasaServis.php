<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JasaServis extends Model
{
    use HasFactory;

    protected $table = 'jasa_servis'; // Pastikan ini sesuai dengan nama tabel di database

    protected $fillable = ['jenis', 'harga'];

}
