<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Karyawan;
use App\Models\JasaServis;
use App\Models\Sparepart;
use App\Models\Riwayat;
use App\Models\User;
use App\Models\Aktivitas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Events\BookingStatusUpdated;

class BookingKaryawanController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::all();
        $karyawans = Karyawan::all();
        $riwayats = Riwayat::all();
        $spareparts = Sparepart::all();
        $jasa_servis = JasaServis::all();

        // Hitung total sparepart
        $totalSparepart = Sparepart::sum('jumlah');

        $aktivitasHariIni = DB::table('users')
            ->whereDate('last_login', now()->toDateString())
            ->count();

        $aktivitasTerkini = Aktivitas::orderBy('created_at', 'desc')->take(10)->get();

        $bulanIni = $request->input('bulan', Carbon::now()->format('m'));
    $tahunIni = Carbon::now()->format('Y');

    $totalPenghasilan = Riwayat::whereYear('tanggal', $tahunIni)
        ->whereMonth('tanggal', $bulanIni)
        ->sum(DB::raw('
            total_harga - 
            (SELECT COALESCE(SUM(sp.harga_beli * rs.jumlah), 0) 
             FROM riwayat_sparepart rs 
             JOIN sparepart sp ON rs.kode_sparepart = sp.kode 
             WHERE rs.riwayat_id = riwayat.id)
        '));

        return view('admin.admindashboard', compact('bookings', 'karyawans', 'riwayats', 'spareparts', 'jasa_servis', 'totalSparepart', 'aktivitasHariIni', 'aktivitasTerkini', 'totalPenghasilan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        if (!$request->has('status')) {
            return response()->json(['message' => 'Status harus diisi'], 400);
        }

        $booking->status = $request->status;

        // Jika status "Disetujui", update waktu datang
        if ($request->status === "Disetujui" && !empty($request->waktu_datang)) {
            $booking->waktu_datang = $request->waktu_datang;
        }

        // Jika status "Dikerjakan", update tanggal_penanganan
        if ($request->status === "Dikerjakan") {
            $booking->tanggal_penanganan = Carbon::now();
        }

        $booking->save();

        return response()->json(['message' => 'Status booking diperbarui!', 'status' => $booking->status]);
    }

    public function kirimKeRiwayat(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

    if (!in_array($booking->status, ['Selesai', 'Sudah Dibayar'])) {
        return response()->json(['message' => 'Status harus "Selesai" atau "Sudah Dibayar" sebelum dikirim ke riwayat'], 400);
    }

    if (!$request->penanganan || !$request->catatan) {
        return response()->json(['message' => 'Penanganan dan Catatan harus diisi'], 400);
    }

        // Pastikan jasa servis ada jika dipilih
        $jasaServis = null;
        if ($request->id_jasa) {
            $jasaServis = JasaServis::find($request->id_jasa);
            if (!$jasaServis) {
                return response()->json(['message' => 'Jasa servis tidak ditemukan'], 400);
            }
        }

        // Hitung total harga dari jasa servis
    $totalHarga = 0;
    if ($request->id_jasa) {
        $jasaServis = JasaServis::find($request->id_jasa);
        if (!$jasaServis) {
            return response()->json(['message' => 'Jasa servis tidak ditemukan'], 400);
        }
        $totalHarga += $jasaServis->harga;
    }
        
        $riwayat = Riwayat::create([
            'tanggal' => Carbon::now(),
            'keluhan' => $booking->keluhan,
            'penanganan' => $request->penanganan,
            'catatan' => $request->catatan,
            'id_karyawan' => $request->id_karyawan,
            'nopol' => $booking->nopol,
            'id_jasa' => $request->id_jasa,
            'ktp_pelanggan' => $booking->nik,
            'status' => $booking->status,
            'total_harga' => $totalHarga
        ]);
    
          // Hitung total harga dari sparepart
          if (!empty($request->spareparts)) {
            foreach ($request->spareparts as $item) {
                $sparepart = Sparepart::where('kode', $item['kode_sparepart'])->first();
                $jumlah = (int) $item['jumlah'];
        
                if ($sparepart && $sparepart->jumlah >= $jumlah) {
                    $sparepart->jumlah -= $jumlah;
                    $sparepart->save();
        
                    // Tambahkan harga sparepart ke total harga
                    $totalHarga += ($sparepart->harga * $jumlah);
        
                    // Simpan ke riwayat_sparepart
                    DB::table('riwayat_sparepart')->insert([
                        'riwayat_id' => $riwayat->id,
                        'kode_sparepart' => $item['kode_sparepart'],
                        'jumlah' => $jumlah,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                } else {
                    return response()->json(['message' => "Stok sparepart {$item['kode_sparepart']} tidak mencukupi!"], 400);
                }
            }
        }      

$riwayat->update(['total_harga' => $totalHarga]);
    
        $booking->delete();
    
        return response()->json(['message' => 'Data berhasil dikirim ke riwayat', 'total_harga' => $totalHarga]);
    }
}
