<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */



    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('admin')->user();
        // في Admin Middleware
if (!$admin || !$admin->role || !in_array($admin->role, ['admin', 'Sub-admin'])) {
    logger('Admin middleware: No authenticated admin.');
    return response()->json(['message' => 'Unauthorized: Only admins can access this route'], 403);
}

        logger('Admin middleware: Admin authenticated.', ['admin' => $admin]);
        return $next($request);
    }

}
