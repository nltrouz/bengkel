<?php

namespace App\Http\Controllers;

use App\Models\JasaServis;
use App\Models\Karyawan;
use App\Models\Riwayat;
use App\Models\Sparepart;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatSparepart;

class RiwayatController extends Controller
{
    // Tambahkan parameter Request di function index
    public function index(Request $request) // <-- Ini yang diperbaiki
    {
        $query = Riwayat::query();

        // Filter by year
        if ($request->has('year') && $request->year != '') {
            $query->whereYear('tanggal', $request->year);
        }

        // Filter by month
        if ($request->has('month') && $request->month != '') {
            $query->whereMonth('tanggal', $request->month);
        }

        // Filter by day
        if ($request->has('day') && $request->day != '') {
            $query->whereDay('tanggal', $request->day);
        }

        // Pindahkan eager loading ke query yang sudah difilter
        $riwayats = $query->with(['karyawan', 'jasaServis', 'spareparts', 'pelanggan'])->get();

        $karyawans = Karyawan::all();
        $jasaServis = JasaServis::all();
        $spareparts = Sparepart::all();

        // Ambil sparepart yang sudah dipilih per riwayat
        $selectedSpareparts = [];
        $selectedJumlahSpareparts = [];

        foreach ($riwayats as $riwayat) {
            $selectedSpareparts[$riwayat->id] = $riwayat->spareparts->pluck('kode')->toArray();
            $selectedJumlahSpareparts[$riwayat->id] = $riwayat->spareparts->pluck('pivot.jumlah', 'kode')->toArray();
        }

        return view('admin.riwayat.index', compact(
            'riwayats',
            'karyawans',
            'jasaServis',
            'spareparts',
            'selectedSpareparts',
            'selectedJumlahSpareparts'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'status' => 'required|string',
            'id_karyawan' => 'required|exists:karyawan,id',
            'id_jasa' => 'required|exists:jasa_servis,id',
            'keluhan' => 'required|string',
            'penanganan' => 'required|string',
            'catatan' => 'nullable|string',
            'nopol' => 'required|string|exists:kendaraan,nopol',
            'ktp_pelanggan' => 'required|string|exists:pelanggan,ktp',
            'kode_sparepart' => 'array',
            'kode_sparepart.*' => 'exists:sparepart,kode',
            'jumlah_sparepart' => 'array',
        ]);

        // Simpan data ke tabel riwayat
        $riwayat = Riwayat::create([
            'tanggal' => $request->tanggal,
            'keluhan' => $request->keluhan,
            'penanganan' => $request->penanganan,
            'catatan' => $request->catatan,
            'id_karyawan' => $request->id_karyawan,
            'id_jasa' => $request->id_jasa,
            'nopol' => $request->nopol,
            'ktp_pelanggan' => $request->ktp_pelanggan,
            'status' => $request->status,
        ]);

        // Simpan sparepart yang digunakan dalam riwayat_sparepart
        if ($request->has('kode_sparepart')) {
            foreach ($request->kode_sparepart as $kode) {
                $jumlah = $request->jumlah_sparepart[$kode] ?? 1; // Default 1 jika jumlah tidak ditemukan

                // Simpan ke tabel riwayat_sparepart
                RiwayatSparepart::create([
                    'riwayat_id' => $riwayat->id,
                    'kode_sparepart' => $kode,
                    'jumlah' => $jumlah,
                ]);

                // Kurangi jumlah stok di tabel sparepart
                $sparepart = Sparepart::where('kode', $kode)->first();
                if ($sparepart && $sparepart->jumlah >= $jumlah) {
                    $sparepart->decrement('jumlah', $jumlah);
                } else {
                    return redirect()->back()->with('error', "Stok untuk sparepart {$kode} tidak cukup!");
                }
            }
        }

        return redirect()->route('admin.riwayat.index')->with('success', 'Riwayat berhasil ditambahkan dan stok sparepart telah diperbarui.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $riwayat = Riwayat::findOrFail($id);
        $riwayat->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.riwayat.index')->with('success', 'Status riwayat berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $riwayat = Riwayat::findOrFail($id);

        // Hapus relasi spareparts dari tabel pivot sebelum menghapus riwayat
        $riwayat->spareparts()->detach();
        $riwayat->delete();

        return redirect()->route('admin.riwayat.index')->with('success', 'Riwayat berhasil dihapus');
    }

    public function invoice($id)
    {
        $riwayat = Riwayat::with(['karyawan', 'jasaServis', 'spareparts', 'pelanggan'])->findOrFail($id);

        // Pastikan Blade template untuk invoice sudah ada
        $pdf = Pdf::loadView('admin.riwayat.invoice', compact('riwayat'));

        return $pdf->stream('invoice.pdf');
    }

    // untuk user
    public function userRiwayat()
    {
        $user = Auth::user();

        // Ambil semua kendaraan milik user yang sedang login
        $kendaraans = $user->kendaraans; // Pastikan relasi kendaraan sudah ada di model User

        // Ambil semua riwayat servis berdasarkan kendaraan milik user
        $riwayats = Riwayat::whereIn('nopol', $kendaraans->pluck('nopol'))
            ->with(['kendaraan', 'jasaServis', 'spareparts'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('dashboard', compact('riwayats'));
    }
}
