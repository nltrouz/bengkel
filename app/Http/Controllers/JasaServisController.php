<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JasaServis;

class JasaServisController extends Controller
{
    public function index()
    {
        $jasa_servis = JasaServis::all();
        return view('admin.jasa_servis.index', compact('jasa_servis'));
    }

    public function store(Request $request)
    {
        JasaServis::create($request->validate([
            'jenis' => 'required|string|max:100',
            'harga' => 'required|integer',
        ]));

        return redirect()->route('admin.jasa_servis.index')->with('success', 'Jasa Servis Ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        $jasa = JasaServis::findOrFail($id);
        $jasa->jenis = $request->jenis;
        $jasa->harga = $request->harga;
        $jasa->save();

        return redirect()->route('admin.jasa_servis.index')->with('success', 'Jasa servis berhasil diperbarui.');
    }

    public function destroy(JasaServis $jasa_servis)
    {
        $jasa_servis->delete();
        return redirect()->route('admin.jasa_servis.index')->with('success', 'Jasa Servis Dihapus!');
    }
}
