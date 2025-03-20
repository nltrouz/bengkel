<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ActivityHelper;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('admin.pelanggan.index', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ktp' => 'required|string|max:50|unique:pelanggan,ktp',
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'hp' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $pelanggan = Pelanggan::create($request->all());

        // Simpan aktivitas
        ActivityHelper::record('Pelanggan ' . $pelanggan->nama . ' ditambahkan.');

        return redirect()->route('admin.pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function update(Request $request, $ktp)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'hp' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $pelanggan = Pelanggan::where('ktp', $ktp)->firstOrFail();
        $pelanggan->update($request->all());

        // Simpan aktivitas
        ActivityHelper::record('Pelanggan ' . $pelanggan->nama . ' diperbarui.');

        return redirect()->route('admin.pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui!');
    }

    public function destroy($ktp)
    {
        $pelanggan = Pelanggan::where('ktp', $ktp)->firstOrFail();
        $nama = $pelanggan->nama; // Ambil nama sebelum dihapus
        $pelanggan->delete();

        // Simpan aktivitas
        ActivityHelper::record('Pelanggan ' . $nama . ' dihapus.');

        return redirect()->route('admin.pelanggan.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}
