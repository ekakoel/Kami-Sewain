<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Ambil waktu timeout dari konfigurasi session
            $timeout = config('session.lifetime') * 60; // konversi ke detik
            
            // Cek waktu terakhir aktivitas user
            $lastActivity = session('last_activity_time', now());
            $inactiveTime = now()->diffInSeconds($lastActivity);

            if ($inactiveTime >= $timeout) {
                Auth::logout();
                return redirect('/login')->withErrors(['message' => 'You have been logged out due to inactivity.']);
            }

            // Update waktu terakhir aktivitas user
            session(['last_activity_time' => now()]);
        }

        return $next($request);
    }
}
