<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsVerified
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_verified) {
            // Arahkan ke halaman khusus jika pengguna belum diverifikasi
            return redirect()->route('unverified');
        }

        return $next($request);
    }
}
