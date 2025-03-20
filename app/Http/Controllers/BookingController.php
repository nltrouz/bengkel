<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Pelanggan;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        $pelanggans = Pelanggan::all(); // Ambil semua pelanggan untuk dropdown

        return view('admin.booking.index', compact('bookings', 'pelanggans'));
    }

    public function store(Request $request)
    {

        Booking::create([
            'nik' => $request->nik,
            'tanggal_booking' => $request->tanggal_booking,
            'tanggal_penanganan' => $request->tanggal_penanganan,
            'waktu_datang' => $request->waktu_datang,
            'status' => $request->status,
            'no_antrian_per_hari' => $request->no_antrian_per_hari,
            'nopol' => $request->nopol,
            'merek' => $request->merek,
            'tipe' => $request->tipe,
            'transmisi' => $request->transmisi,
            'kapasitas' => $request->kapasitas,
            'tahun' => $request->tahun,
        ]);

        return redirect()->route('admin.booking.index')->with('success', 'Booking berhasil ditambahkan!');
    }

    public function show($id)
    {
        $booking = Booking::with('pelanggan')->findOrFail($id);
        return view('admin.booking.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return response()->json($booking);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|string',
            'tanggal_booking' => 'required|date',
            'tanggal_penanganan' => 'required|date',
            'waktu_datang' => 'nullable|date',
            'status' => 'required|string',
            'no_antrian_per_hari' => 'required|string',
            'nopol' => 'required|string',
            'merek' => 'required|string',
            'tipe' => 'required|string',
            'transmisi' => 'required|string',
            'kapasitas' => 'required|integer',
            'tahun' => 'required|integer',
        ]);

        $booking = Booking::findOrFail($id);

        $booking->update($request->all());

        return redirect()->route('admin.booking.index')->with('success', 'Booking berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.booking.index')->with('success', 'Booking berhasil dihapus!');
    }
}
