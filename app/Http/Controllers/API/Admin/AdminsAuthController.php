<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\login;
use App\Http\Requests\admin\store;
use App\Models\Admin;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminsAuthController extends Controller
{  
    // Admin login
    public function login(login $request)
    {
        $admin = Admin::where('email', $request->email)->first();
    
        // Check if admin exists and verify password manually
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'admin' => $admin,
            'token' => $admin->createToken('Access Token for ' . $admin->name)->plainTextToken,
        ]);
    }
    

    // Register new admin (only if no admin exists)
    public function register(store $request)
    {
        if (Admin::count() > 0) {
            return response()->json(['message' => 'An admin is already registered.'], 403);
        }

        $admin = Admin::create($request->validated());

        return response()->json([
            'admin' => $admin,
            'token' => $admin->createToken('admin-token')->plainTextToken,
        ], 201);
    }

    // Admin logout
    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user(); // Get authenticated admin
    
        if (!$admin) {
            return response()->json(['error' => 'Unauthorized access. Admins only.'], 403);
        }
    
        // Revoke current access token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
      
}
