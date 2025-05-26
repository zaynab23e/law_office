<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\login;
use App\Http\Requests\admin\store;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(store $request)
    {

        $validatedDate = $request->validated();
        if (Admin::count() > 0) {
            return response()->json(['message' => 'An admin already exists.'], 403);
        }
        $admin = Admin::create([
            'email' => $validatedDate['email'],
            'password' => Hash::make($validatedDate['password']),
        ]);
        return response()->json([
            'message' => 'admin registration successful',
            'admin' => $admin,
        ], 201);
    }
    public function loadLoginPage()
    {
        return view('login');
    }

    public function loginUser(login $request)
    {
        $credentials = $request->validated();
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard')->with('success', 'تم تسجيل الدخول بنجاح');
        }

        return back()->withErrors(['error' => 'بيانات غير صحيحة'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('loginPage')->with('success', 'تم تسجيل الخروج بنجاح');
    }
}
