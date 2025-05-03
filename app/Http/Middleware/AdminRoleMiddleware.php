<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated midwife has admin role
        if (Auth::guard('midwives')->check() && Auth::guard('midwives')->user()->role === 'admin') {
            return $next($request);
        }

        // Redirect or abort if not admin
        return abort(403, 'Unauthorized. Only midwives with admin role can access this page.');
    }
}
