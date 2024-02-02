<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthAdmin extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['loginAdmin','registerAdmin','logoutAdmin']]);
    }




    public function registerAdmin(Request $request)
    {
        $credentials = $request->only('professional_id', 'password');
        $request->merge(['password' => Hash::make($request->password)]);
        $request->validate([
            'professional_id' => 'required|string|max:11|unique:admins',
            'password' => 'required|string|min:8',
            'name' => 'required|string|max:500',
        ]);
        
        
        $user = Admin::create([

            'name' => $request->name,
            'professional_id' => $request->professional_id,
            'password' => $request->password,
        ]);
        $token = Auth::guard('admin')->login($user);
        return  response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
            'token' => $token,
            'type' => 'bearer',
            ]
        ]);
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'professional_id' => 'required|string',
            'password' => 'required|string',
        ]);

        
        $credentials = $request->only('professional_id', 'password');

        $token = Auth::guard('admin')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::guard('admin')->user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
                ]
            ]);

    }



    public function logoutAdmin()
    {
        Auth::guard('admin')->logoutAdmin();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

}