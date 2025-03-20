<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if(!Auth::check()){
            return redirect()->back();
        }
        $user = Auth::user();
        if($role == 'admin'){
            if ($user->role == 'admin') {
                return $next($request);
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
        
        return redirect('/login')->with('error', 'Akses ditolak! Anda bukan admin.');
    }
}