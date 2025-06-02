<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin || !$admin->role || $admin->role !== 'Sub-Admin') {
            logger('Admin middleware: No authenticated admin.');
            return response()->json(['message' => 'Unauthorized: Only sub-admins can access this route'], 403);
        }

        logger('Admin middleware: Admin authenticated.', ['admin' => $admin]);
        return $next($request);
    }
}
