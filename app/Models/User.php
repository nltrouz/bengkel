<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Pelanggan;
use App\Models\Kendaraan; // Import model Kendaraan

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $primaryKey = 'nik_ktp';
    public $incrementing = false; // Jika `nik_ktp` bukan auto-increment
    protected $keyType = 'string';
    protected $fillable = ['nik_ktp', 'name', 'email', 'password', 'role'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // User model
    public function pelanggan()
    {
        return $this->hasOne(Pelanggan::class, 'ktp', 'nik_ktp');
    }

    public function kendaraans()
    {
        return $this->hasManyThrough(
            Kendaraan::class,      // Model tujuan akhir
            Pelanggan::class,      // Model perantara
            'ktp',                 // FK di Pelanggan (mengacu ke User)
            'id_pelanggan',        // FK di Kendaraan (mengacu ke Pelanggan)
            'nik_ktp',             // PK di User
            'ktp'                  // PK di Pelanggan
        );
    }
}
