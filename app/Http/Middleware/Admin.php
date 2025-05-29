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
    public function handle(Request $request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin || $admin->id !== 1) {
            return response()->json(['message' => 'Unauthorized: Super admin only'], 403);
        }

    
    logger('Admin middleware: Admin authenticated.', ['admin' => $admin]);
    return $next($request);
}

}
