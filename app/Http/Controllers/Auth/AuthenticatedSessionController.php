<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Helpers\ActivityHelper; // Pastikan ActivityHelper diimport
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Cek role user setelah login
        $user = Auth::user();

        // Simpan aktivitas login
        ActivityHelper::record($user->name . ' berhasil login');

        if ($user->role == 'admin') {
            return redirect()->route('admin.admindashboard'); // Redirect admin ke dashboard admin
        }

        return redirect()->intended('dashboard'); // Redirect user biasa ke halaman user
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Simpan aktivitas logout sebelum logout
        ActivityHelper::record(Auth::user()->name . ' berhasil logout');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
