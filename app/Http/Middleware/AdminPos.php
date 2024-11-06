<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminPos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$positions): Response
    {
        if (Auth::guard('admin')->check() && in_array(Auth::guard('admin')->user()->position, $positions)) {
            return $next($request);
        }
        return redirect()->route('admin.home')->with('error', 'You do not have access to this page.');
    }
}
