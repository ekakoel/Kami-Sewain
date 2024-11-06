<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserSession
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Cek apakah session ID yang tersimpan di database sama dengan session saat ini
            if ($user->session_id !== session()->getId()) {
                Auth::logout();
                return redirect('/login')->withErrors(['message' => 'You have logged in on another device.']);
            }
        }

        return $next($request);
    }
}
