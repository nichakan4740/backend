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

    public function registerAdmin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $request->merge(['password' => Hash::make($request->password)]);
        $username = explode('@', $request->email)[0];
        $user = Admin::create([
            'name' => $username,
            'username' => $username,
            'email' => $request->email,
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
    /* {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = auth()->guard('admin')->attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'Some Error Message'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }
        return $this->finalResponse($token);
    } */

    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        
        $credentials = $request->only('email', 'password');

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


}