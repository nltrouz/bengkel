<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riwayat;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\Auth;

class RiwayatUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil kendaraan berdasarkan user yang sedang login
        $kendaraanUser = Kendaraan::where('id_pelanggan', $user->nik_ktp)->get();

        // Ambil riwayat berdasarkan pelanggan yang sedang login
        $riwayat = Riwayat::where('ktp_pelanggan', $user->nik_ktp)->get();

        return view('dashboard', compact('riwayat', 'kendaraanUser'));
    }
}
