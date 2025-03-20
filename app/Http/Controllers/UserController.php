<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Aktivitas;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik_ktp' => 'required|string|unique:users,nik_ktp',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string'
        ]);

        Log::info("Data yang akan disimpan: ", $validatedData);

        $user = User::create([
            'nik_ktp' => $validatedData['nik_ktp'],
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => $validatedData['role']
        ]);

        Log::info("User berhasil dibuat: ", ['user' => $user]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, $nik_ktp)
{
    // Validasi data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $nik_ktp . ',nik_ktp',
        'role' => 'required|in:user,admin',
    ]);

    // Cari user berdasarkan nik_ktp
    $user = User::where('nik_ktp', $nik_ktp)->firstOrFail();

    // Update user dengan data baru
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
    ]);

    return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui');
}

    public function destroy($nik_ktp)
{
    $user = User::where('nik_ktp', $nik_ktp)->firstOrFail();
    $user->delete();
    
    return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
}

}
