<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riwayat;

class InvoiceController extends Controller
{
    public function showAjax($id)
{
    $riwayat = Riwayat::with(['jasaServis', 'spareparts', 'karyawan', 'pelanggan'])->findOrFail($id);
    return view('partials.invoice', compact('riwayat'))->render();
}

}
