<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MidwifeAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated as midwife
        if (!Auth::guard('midwife')->check()) {
            abort(403, 'Unauthorized access');
        }

        // Get midwife user
        $midwife = Auth::guard('midwife')->user();

        // Check if role exists and is 'admin'
        if (!isset($midwife->role) || $midwife->role === null || empty($midwife->role) || $midwife->role !== 'admin') {
            abort(403, 'Admin access required');
        }

        return $next($request);
    }
}
