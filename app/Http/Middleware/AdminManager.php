<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->position === 'Manager') {
            return $next($request);
        }
        return redirect()->route('admin.dashboard')->with('error', 'You do not have access to this page.');
    }
}
