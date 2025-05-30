<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Assistant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin || !$admin->role || $admin->role !== 'Assistant') {
            logger('Admin middleware: No authenticated admin.');
            return response()->json(['message' => 'Unauthorized: Only assistants can access this route'], 403);
        }

        logger('Admin middleware: Admin authenticated.', ['admin' => $admin]);
        return $next($request);
    }
}
