<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminDeveloper
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->position === 'Developer') {
            return $next($request);
        }
        return redirect()->route('admin.home')->with('error', 'You do not have access to this page.');
    }
}
