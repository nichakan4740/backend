<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthAdmin extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','refresh','logout']]);
    }

    public function register(Request $request){
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'professional_license_number' => 'required|string|max:10|unique:admins',
            'password' => 'required|string|min:8',
        ]);

        $admin = Admin::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'professional_license_number' => $request->professional_license_number,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::guard('api')->login($admin);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'admin' => $admin,
            'authorisation' => [
            'token' => $token,
            'type' => 'bearer',
            ]
        ]);
    }




    public function login(Request $request)
    {
        $request->validate([
            'professional_license_number' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('professional_license_number', 'password');

        $token = Auth::guard('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $admin = Auth::guard('api')->user();
        return response()->json([
                'status' => 'success',
                'admin' => $admin,
                'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
                ]
            ]);

    }



    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }


    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'admin' => Auth::guard('api')->admin(),
            'authorisation' => [
                'token' => Auth::guard('api')->refresh(),
                'type' => 'bearer',
            ]
        ]);
    }


    
}