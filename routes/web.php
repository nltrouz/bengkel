<?php

use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JasaServisController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookingUserController;
use App\Http\Controllers\WelcomeController;
use App\Models\Booking;
use Illuminate\Http\Request;

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ✅ Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Group Route untuk Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/admindashboard', [AdminController::class, 'index'])->name('admindashboard');

    // ✅ Kelola Pelanggan
    Route::resource('pelanggan', PelangganController::class)
        ->except(['show', 'create', 'edit'])
        ->names([
            'index' => 'pelanggan.index',
            'store' => 'pelanggan.store',
            'update' => 'pelanggan.update',
            'destroy' => 'pelanggan.destroy'
        ]);

    // ✅ Kelola Kendaraan
    Route::resource('kendaraan', KendaraanController::class)
        ->except(['show', 'create', 'edit'])
        ->names([
            'index' => 'kendaraan.index',
            'store' => 'kendaraan.store',
            'update' => 'kendaraan.update',
            'destroy' => 'kendaraan.destroy'
        ]);

    // ✅ Tambahkan rute untuk melihat semua kendaraan (khusus admin)
    Route::get('/kendaraan/all', [KendaraanController::class, 'adminIndex'])->name('kendaraan.adminIndex');

    // ✅ Kelola Sparepart
    Route::resource('sparepart', SparepartController::class)
        ->except(['show', 'create', 'edit'])
        ->names([
            'index' => 'sparepart.index',
            'store' => 'sparepart.store',
            'update' => 'sparepart.update',
            'destroy' => 'sparepart.destroy'
        ]);

    // ✅ Kelola Users
    Route::resource('users', UserController::class)
        ->except(['show'])
        ->names([
            'index' => 'users.index',
            'store' => 'users.store',
            'update' => 'users.update',
            'destroy' => 'users.destroy'
        ]);

    // ✅ Kelola Jasa Servis
    Route::resource('jasa_servis', JasaServisController::class)
        ->except(['show', 'create', 'edit'])
        ->names([
            'index' => 'jasa_servis.index',
            'store' => 'jasa_servis.store',
            'update' => 'jasa_servis.update',
            'destroy' => 'jasa_servis.destroy'
        ]);

    // ✅ Kelola Booking
    Route::resource('booking', BookingController::class)
        ->except(['show'])
        ->names([
            'index' => 'booking.index',
            'store' => 'booking.store',
            'update' => 'booking.update',
            'destroy' => 'booking.destroy'
        ]);

    // ✅ Kelola Riwayat
    Route::resource('riwayat', RiwayatController::class)
        ->except(['show', 'create', 'edit'])
        ->names([
            'index' => 'riwayat.index',
            'store' => 'riwayat.store',
            'update' => 'riwayat.update',
            'destroy' => 'riwayat.destroy'
        ]);
});

// ✅ Cek apakah user sudah login atau belum
Route::get('/check-auth', function () {
    return response()->json([
        'authenticated' => Auth::check()
    ]);
});

// ✅ User Routes
Route::middleware(['auth'])->group(function () {
    // ✅ Menampilkan kendaraan user yang login (untuk dashboard user)
    Route::get('/dashboard/kendaraan', [KendaraanController::class, 'getKendaraanUser'])->name('dashboard.kendaraan');

    // ✅ Menampilkan kendaraan yang dimiliki user login
    Route::get('/kendaraan', [KendaraanController::class, 'index'])->name('kendaraan.index');

    // ✅ Form tambah kendaraan (hanya jika user sudah menjadi pelanggan)
    Route::get('/kendaraan/tambah', function () {
        $user = Auth::user();
        if (!$user->pelanggan) {
            return redirect()->route('pelanggan.index')->with('error', 'Anda harus terdaftar sebagai pelanggan sebelum menambahkan kendaraan.');
        }
        return app(KendaraanController::class)->create();
    })->name('kendaraan.create');

    // ✅ Proses tambah kendaraan
    Route::post('/kendaraan', [KendaraanController::class, 'store'])->name('kendaraan.store');

    // ✅ Form edit kendaraan (hanya jika kendaraan milik user)
    Route::get('/kendaraan/{nopol}/edit', [KendaraanController::class, 'edit'])->name('kendaraan.edit');

    // ✅ Proses update kendaraan
    Route::put('/kendaraan/{nopol}', [KendaraanController::class, 'update'])->name('kendaraan.update');

    // ✅ Hapus kendaraan
    Route::delete('/kendaraan/{nopol}', [KendaraanController::class, 'destroy'])->name('kendaraan.destroy');
});

// bookinguser
Route::middleware(['auth'])->group(function () {
    Route::get('/booking-form', [BookingUserController::class, 'showBookingForm'])->name('booking.form');
    Route::post('/booking', [BookingUserController::class, 'storeBooking'])->name('booking.store');
    Route::delete('/booking/{no_urut}', [BookingUserController::class, 'destroy'])->name('booking.destroy');
});

Route::get('/get-antrian', [BookingUserController::class, 'getAntrian']);

// bookingkarywan
use App\Http\Controllers\BookingKaryawanController;

Route::get('/admin/admindashboard', [BookingKaryawanController::class, 'index'])->name('admin.admindashboard');
Route::get('/booking-karyawan', [BookingKaryawanController::class, 'index']);
Route::post('/booking-karyawan/update-status/{id}', [BookingKaryawanController::class, 'updateStatus']);
Route::post('/booking-karyawan/kirim-ke-riwayat/{id}', [BookingKaryawanController::class, 'kirimKeRiwayat']);

// riwayat - usercontroller
Route::get('/riwayat', [UserController::class, 'riwayatUser'])
    ->name('riwayat.user')
    ->middleware('auth');

// riwayat invoice
Route::get('/riwayat/{id}/invoice', [RiwayatController::class, 'invoice'])->name('admin.riwayat.invoice');

Route::post('/booking/store', [BookingUserController::class, 'storeBooking'])
    ->name('booking.store')
    ->middleware(['auth']);

Route::get('/booking-status', [BookingUserController::class, 'getBookingStatus'])
    ->middleware('auth')
    ->name('booking.status');

Route::get('/dashboard', [BookingUserController::class, 'showDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

use App\Http\Controllers\RiwayatUserController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [RiwayatUserController::class, 'index'])->name('dashboard');
});

use App\Http\Controllers\InvoiceController;

Route::get('/invoice/{id}', [InvoiceController::class, 'showAjax'])->name('invoice.showAjax');

Route::middleware(['auth'])->group(function () {
    Route::put('/booking/{no_urut}', [BookingUserController::class, 'update'])->name('booking.update');
});

require __DIR__ . '/auth.php';
