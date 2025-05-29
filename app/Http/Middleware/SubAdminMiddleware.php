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

        if (!$admin || $admin->role !== 'subAdmin') {
            return response()->json(['message' => 'Unauthorized: Sub Assistant only'], 403);
        }

        // if ($request->method() !== 'POST') {
        //     return response()->json(['message' => 'Unauthorized: You can only perform CREATE operations'], 403);
        // }

        return $next($request);
    }
}
