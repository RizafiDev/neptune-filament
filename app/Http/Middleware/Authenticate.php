<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::check() && !Auth::user()->is_verified) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda belum diverifikasi oleh admin. Tunggu Beberapa Saat :)',
            ]);
        }

        return $next($request);
    }
}
