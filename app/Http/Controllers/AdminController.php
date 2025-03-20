<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;
use App\Models\Aktivitas;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Karyawan;
use App\Models\Riwayat;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil 5 aktivitas terbaru
        $aktivitasTerkini = Aktivitas::orderBy('created_at', 'desc')->limit(5)->get();

        // Hitung total sparepart
        $totalSparepart = Sparepart::count();

        // Hitung jumlah aktivitas hari ini
        $aktivitasHariIni = Aktivitas::whereDate('created_at', Carbon::today())->count();

        // Ambil semua data booking dan karyawan dari database
        $bookings = Booking::all();
        $karyawans = Karyawan::all();
        $riwayats = Riwayat::all();
        $spareparts = Sparepart::all();

         // Kirim semua variabel ke view
         return view('admin.admindashboard', compact('aktivitasTerkini', 'totalSparepart', 'aktivitasHariIni', 'bookings', 'karyawans', 'riwayats', 'spareparts'));
    }

    public function pelanggan()
    {
        return view('admin.pelanggan.index');
    }

    public function kendaraan()
    {
        return view('admin.kendaraan.index');
    }

    public function sparepart()
    {
        return view('admin.sparepart.index');
    }

    public function users()
    {
        return view('admin.users.index');
    }
}
