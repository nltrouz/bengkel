<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KendaraanController extends Controller
{
    // ✅ Menampilkan kendaraan berdasarkan peran
    public function index(Request $request)
    {
        $user = Auth::user();
        $idPelanggan = optional($user->pelanggan)->ktp;

        // Ambil semua pelanggan untuk dropdown (admin only)
        $pelanggan = Pelanggan::all();

        if ($request->wantsJson()) {
            if ($user->role === 'admin') {
                return response()->json(Kendaraan::with('pelanggan')->get());
            }
            return response()->json(Kendaraan::where('id_pelanggan', $idPelanggan)->get());
        }

        // Jika tidak meminta JSON, kembalikan tampilan HTML
        $kendaraan = Kendaraan::with('pelanggan')->get();
        return view('admin.kendaraan.index', compact('kendaraan', 'pelanggan'));
    }

    // ✅ Untuk Dashboard: Menampilkan kendaraan user login
    public function getKendaraanUser()
    {
        $user = Auth::user();
        $idPelanggan = optional($user->pelanggan)->ktp;

        if (!$idPelanggan) {
            return collect(); // Mengembalikan collection kosong jika tidak ada kendaraan
        }

        return Kendaraan::where('id_pelanggan', $idPelanggan)->get();
    }

    // ✅ Untuk Admin: Menampilkan semua kendaraan
    public function adminIndex()
    {
        $kendaraan = Kendaraan::with('pelanggan')->get();
        return view('admin.kendaraan.index', compact('kendaraan'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::all();
        return view('kendaraan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nopol' => 'required|string|max:20|unique:kendaraan,nopol',
            'merek' => 'required|string|max:50',
            'tipe' => 'required|string|max:50',
            'transmisi' => 'required|string|max:20|in:manual,matic',
            'kapasitas' => 'required|integer|between:50,3000',
            'tahun' => 'required|integer|between:1950,' . date('Y'),
            'id_pelanggan' => 'nullable|exists:pelanggan,ktp'
        ]);

        $user = Auth::user();
        $idPelanggan = $user->role === 'admin' ? $request->id_pelanggan : optional($user->pelanggan)->ktp;

        if (!$idPelanggan) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar sebagai pelanggan.');
        }

        Kendaraan::create([
            'nopol' => $request->nopol,
            'merek' => $request->merek,
            'tipe' => $request->tipe,
            'transmisi' => $request->transmisi,
            'kapasitas' => $request->kapasitas,
            'tahun' => $request->tahun,
            'id_pelanggan' => $idPelanggan
        ]);

        // 🔥 Cek role user dan arahkan ke halaman yang benar
        if ($user->role === 'admin') {
            return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil ditambahkan');
        } else {
            return redirect()->route('dashboard')->with('success', 'Kendaraan berhasil ditambahkan');
        }
    }

    public function edit($nopol)
    {
        $user = Auth::user();
        $idPelanggan = optional($user->pelanggan)->ktp;

        if ($user->role !== 'admin' && !$idPelanggan) {
            return redirect()->route('kendaraan.index')->with('error', 'Anda tidak memiliki akses ke kendaraan ini.');
        }

        $kendaraan = Kendaraan::where('nopol', $nopol)
            ->when($user->role !== 'admin', function ($query) use ($idPelanggan) {
                return $query->where('id_pelanggan', $idPelanggan);
            })
            ->firstOrFail();

        return view('kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, $nopol)
    {
        $request->validate([
            'merek' => 'required|string|max:50',
            'tipe' => 'required|string|max:50',
            'transmisi' => 'required|string|max:20|in:manual,matic',
            'kapasitas' => 'required|integer|between:50,3000',
            'tahun' => 'required|integer|between:1950,' . date('Y'),
        ]);

        $user = Auth::user();
        $idPelanggan = optional($user->pelanggan)->ktp;

        $kendaraan = Kendaraan::where('nopol', $nopol)
            ->when($user->role !== 'admin', function ($query) use ($idPelanggan) {
                return $query->where('id_pelanggan', $idPelanggan);
            })
            ->firstOrFail();

        $kendaraan->update($request->all());

        // 🔥 Redirect berdasarkan peran
        if ($user->role === 'admin') {
            return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil diperbarui');
        } else {
            return redirect()->route('dashboard')->with('success', 'Data kendaraan berhasil diperbarui');
        }
    }

    public function destroy($nopol)
    {
        $user = Auth::user();
        $idPelanggan = optional($user->pelanggan)->ktp;

        $kendaraan = Kendaraan::where('nopol', $nopol)
            ->when($user->role !== 'admin', function ($query) use ($idPelanggan) {
                return $query->where('id_pelanggan', $idPelanggan);
            })
            ->firstOrFail();

        $kendaraan->delete();

        // 🔥 Redirect berdasarkan peran
        if ($user->role === 'admin') {
            return redirect()->route('kendaraan.index')->with('success', 'Kendaraan berhasil dihapus');
        } else {
            return redirect()->route('dashboard')->with('success', 'Kendaraan berhasil dihapus');
        }
    }

}
