<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::all();
        return view('admin.sparepart.index', compact('spareparts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:sparepart,kode|max:20',
            'nama' => 'required|max:100',
            'jumlah' => 'required|integer',
            'harga' => 'required|integer',
        ]);

        Sparepart::create($request->all());

        return redirect()->route('admin.sparepart.index')->with('success', 'Sparepart berhasil ditambahkan.');
    }

    public function update(Request $request, $kode)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'jumlah' => 'required|integer|min:0',
            'harga' => 'required|integer|min:0',
        ]);        

        $sparepart = Sparepart::where('kode', $kode)->firstOrFail();
        $sparepart->update($request->all());

        return redirect()->route('admin.sparepart.index')->with('success', 'Sparepart berhasil diperbarui.');
    }

    public function destroy($kode)
    {
        $sparepart = Sparepart::where('kode', $kode)->firstOrFail();
        $sparepart->delete();

        return redirect()->route('admin.sparepart.index')->with('success', 'Sparepart berhasil dihapus.');
    }
}
