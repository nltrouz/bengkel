<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingUserController extends Controller
{
    // File: app/Http/Controllers/BookingUserController.php
    public function showBookingForm(Request $request)
    {
        $user = Auth::user(); // Ambil user yang login

        // Pastikan user tidak null
        if (!$user) {
            return abort(403, "User tidak ditemukan");
        }

        $kendaraanUser = $user->kendaraans;
        $tanggal_booking = request()->input('tanggal_booking', today()->toDateString());
        $nextAntrian = $this->calculateNextAntrian($tanggal_booking);

        // Ambil semua booking yang dimiliki user
        $bookings = Booking::where('nik', $user->nik_ktp)->get();

        // Tentukan view yang dikembalikan berdasarkan request
        $view = $request->query('source') === 'dashboard' ? 'dashboard' : 'welcome';

        return view($view, compact('kendaraanUser', 'bookings'));
    }

    private function calculateNextAntrian($tanggal, $excludeNoUrut = null)
    {
        return DB::transaction(function () use ($tanggal, $excludeNoUrut) {
            // Ambil nomor antrian terakhir untuk tanggal booking yang sama
            $query = Booking::whereDate('tanggal_booking', $tanggal)
                ->lockForUpdate();

            // Jika digunakan untuk update, jangan hitung booking yang sedang di-update
            if ($excludeNoUrut) {
                $query->where('no_urut', '!=', $excludeNoUrut);
            }

            $lastAntrian = $query->max('no_antrian_per_hari');

            return $lastAntrian ? $lastAntrian + 1 : 1;
        });
    }

    public function storeBooking(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melakukan booking.');
        }

        if ($user->kendaraans->isEmpty()) {
            return redirect()->back()->with('error', 'Anda belum memiliki kendaraan terdaftar.');
        }

        $request->validate([
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'nopol' => 'required|exists:kendaraan,nopol',
            'keluhan' => 'nullable|string|max:1000',
        ]);

        $tanggalBooking = $request->tanggal_booking;

        // **Cek jumlah booking pada tanggal tersebut**
        $jumlahBookingHariIni = Booking::whereDate('tanggal_booking', $tanggalBooking)->count();
        if ($jumlahBookingHariIni >= 5) {
            return redirect()->back()->with('error', 'Booking untuk tanggal ini sudah penuh. Silakan pilih tanggal lain.');
        }

        // Cek apakah kendaraan sudah ada dalam booking yang belum selesai
        $existingBooking = Booking::where('nopol', $request->nopol)
            ->where('status', '!=', 'Selesai') // Sesuaikan dengan status booking yang menunjukkan masih aktif
            ->exists();

        if ($existingBooking) {
            return redirect()->back()->with('error', 'Kendaraan ini sudah memiliki booking yang sedang diproses.');
        }

        $kendaraan = Kendaraan::where('nopol', $request->nopol)
            ->where('id_pelanggan', $user->nik_ktp)
            ->first();

        if (!$kendaraan) {
            return redirect()->back()->with('error', 'Kendaraan tidak ditemukan.');
        }

        // Kirim tanggal booking ke calculateNextAntrian()
        $nextAntrian = $this->calculateNextAntrian($request->tanggal_booking);

        Booking::create([
            'nik' => Auth::user()->nik_ktp,
            'tanggal_booking' => $request->tanggal_booking,
            'tanggal_penanganan' => null,
            'no_antrian_per_hari' => $nextAntrian,
            'nopol' => $kendaraan->nopol,
            'merek' => $kendaraan->merek,
            'tipe' => $kendaraan->tipe,
            'transmisi' => $kendaraan->transmisi,
            'kapasitas' => $kendaraan->kapasitas,
            'tahun' => $kendaraan->tahun,
            'keluhan' => $request->keluhan,
            'status' => 'Menunggu',
            'waktu_datang' => null,
        ]);

        return redirect()->back()->with('success', 'Booking berhasil dibuat!');
    }

    public function getAntrian(Request $request)
    {
        $tanggal = $request->query('tanggal', today()->toDateString());

        $antrian = Booking::whereDate('tanggal_booking', $tanggal)
            ->orderBy('no_antrian_per_hari')
            ->get();

        return response()->json($antrian);
    }

    public function destroy($no_urut)
    {
        try {
            $booking = Booking::where('no_urut', $no_urut)->first();

            if (!$booking) {
                return redirect()->back()->with('error', 'Booking tidak ditemukan!');
            }

            // Pastikan user yang login adalah pemilik booking
            if (Auth::user()->nik_ktp !== $booking->nik) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus booking ini!');
            }

            // Hanya bisa dihapus jika status masih 'Menunggu'
            if ($booking->status !== 'Menunggu') {
                return redirect()->back()->with('error', 'Booking hanya bisa dibatalkan jika status masih Menunggu!');
            }

            $booking->delete();

            return redirect()->route('dashboard')->with('success', 'Booking berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function showDashboard()
    {
        $user = Auth::user();

        if (!$user) {
            return abort(403, "User tidak ditemukan");
        }

        $kendaraanUser = $user->kendaraans;

        return view('dashboard', compact('kendaraanUser'));
    }

    public function getBookingStatus()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $bookingStatus = Booking::whereIn('nopol', $user->kendaraan->pluck('nopol'))
            ->orderByRaw("FIELD(status, 'Tunggu', 'Disetujui', 'Menunggu Antrian', 'Dikerjakan', 'Selesai', 'Sudah Dibayar', 'Dibatalkan')")
            ->get()
            ->fresh();

        Log::info('Booking Data:', $bookingStatus->toArray());

        return response()->json($bookingStatus);
    }

    public function edit($no_urut)
    {
        $booking = Booking::findOrFail($no_urut);
        $user = Auth::user();

        // Pastikan hanya pemilik booking yang bisa mengedit
        if ($booking->nik !== $user->nik_ktp) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit booking ini!');
        }

        // Pastikan hanya booking dengan status "Menunggu" yang bisa diedit
        if ($booking->status !== 'Menunggu') {
            return redirect()->back()->with('error', 'Booking hanya bisa diedit jika status masih "Menunggu"');
        }

        return view('dashboard', compact('booking')); // Gunakan view yang sudah ada
    }

    public function update(Request $request, $no_urut)
    {
        $booking = Booking::findOrFail($no_urut);
        $user = Auth::user();

        // Pastikan hanya pemilik booking yang bisa mengedit
        if ($booking->nik !== $user->nik_ktp) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit booking ini!');
        }

        // Pastikan hanya booking dengan status "Menunggu" yang bisa diedit
        if ($booking->status !== 'Menunggu') {
            return redirect()->back()->with('error', 'Booking hanya bisa diedit jika status masih "Menunggu"');
        }

        // Validasi input
        $request->validate([
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'keluhan' => 'nullable|string|max:1000',
        ]);

        $tanggalBaru = $request->tanggal_booking;
        $tanggalLama = $booking->tanggal_booking;

        // Jika tanggal berubah, hitung ulang nomor antrian
        if ($tanggalBaru !== $tanggalLama) {
            $nextAntrian = $this->calculateNextAntrian($tanggalBaru, $booking->no_urut);
        } else {
            $nextAntrian = $booking->no_antrian_per_hari;
        }

        // Update booking
        $booking->update([
            'tanggal_booking' => $tanggalBaru,
            'keluhan' => $request->keluhan,
            'no_antrian_per_hari' => $nextAntrian,
        ]);

        return redirect()->route('dashboard')->with('success', 'Booking berhasil diperbarui!');
    }
}
