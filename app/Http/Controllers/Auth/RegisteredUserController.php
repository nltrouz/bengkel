<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        // Validasi Input
        $request->validate([
            'nik_ktp' => ['required', 'string', 'max:50', 'unique:users,nik_ktp'],
            'name' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'hp' => ['required', 'string', 'max:15'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password' => ['required', 'confirmed', 'min:3'],
        ]);

        // Simpan ke tabel Users
        $user = User::create([
            'nik_ktp' => $request->nik_ktp,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Simpan ke tabel Pelanggan
        Pelanggan::create([
            'ktp' => $request->nik_ktp, // Foreign key ke users
            'nama' => $request->name,
            'alamat' => $request->alamat,
            'hp' => $request->hp,
        ]);

        //dd($user->nik_ktp);
        //dd($user);
        // Login otomatis setelah registrasi
        Auth::loginUsingId($user->nik_ktp);

        return redirect()->route('dashboard'); // Redirect ke halaman setelah login
    }
}
