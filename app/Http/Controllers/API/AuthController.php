<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\loginUserRequest;
use App\Http\Requests\user\storeUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(storeUserRequest $request)
    { 
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            $image->move(public_path('users'), $imageName);
    
            $validatedData['image'] = env('APP_URL') . '/public/users/' . $imageName;
        }
        $user = User::create($validatedData);     
        $user->save();
        return response()->json([ 
            'message' => ' تم التسجيل بنجاح ، برجاء الانتظار حتي يتم قبول طلب سيادتكم.'
        ], 201);
    }

    public function login(loginUserRequest $request)
    {
        $validatedData = $request->validated();
        $user = User::where('email', $request->input('email'))->first();
    
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json("بيانات غير صحيحة", 404);
        }
    
        if (!$user->approved) {
            return response()->json(" حسابك لم يتم الموافقة عليه من قبل الإدارة حتي الان برجاء الانتظار", 403);
        }
    
        $token = $user->createToken('Api token of ' . $user->name)->plainTextToken;
    
        return response()->json([
            'user' => $user->only(['id', 'name', 'email']),
            'token' => $token
        ], 200);
    }
    

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json(
            (Auth::user()->name . '، لقد تم تسجيل الخروج بنجاح وتم حذف الرمز الخاص بك'), 200
        );
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
   
        $user = User::where('email', $request->email)->first();
   
        if (!$user) {
            return response()->json('المستخدم غير موجود', 404);
        }
   
        $code = mt_rand(100000, 999999);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token'      => $code,
                'created_at' => now()
            ]
        );
   
        Mail::raw("رمز إعادة تعيين كلمة المرور الخاص بك هو: $code", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('رمز إعادة تعيين كلمة المرور');
        });
   
        return response()->json('تم إرسال رمز إعادة تعيين كلمة المرور إلى بريدك الإلكتروني', 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'code'     => 'required|numeric',
            'password' => 'required|confirmed',
        ]);

        $resetEntry = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$resetEntry) {
            return response()->json('الرمز غير صحيح', 400); 
        }
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        return response()->json('تم إعادة تعيين كلمة المرور بنجاح', 200);
    }
}
