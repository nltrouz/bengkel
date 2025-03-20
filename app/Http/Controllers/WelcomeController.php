<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kendaraan;

class WelcomeController extends Controller
{
    public function index()
{
    // Cek apakah user sedang login
    $user = Auth::user();

    // Jika user login, ambil kendaraan berdasarkan NIK, jika tidak login, set ke koleksi kosong
    $kendaraanUser = $user ? Kendaraan::where('id_pelanggan', $user->nik_ktp)->get() : collect([]);

    return view('welcome', compact('kendaraanUser'));
}
}
