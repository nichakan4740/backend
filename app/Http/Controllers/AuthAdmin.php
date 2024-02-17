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
        $this->middleware('auth:admin', ['except' => ['loginAdmin','registerAdmin','logoutAdmin']]);
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
        $user = Admin::where('professional_id', $request->professional_id)->first();

        if (!$user) {
            // User not found (404)
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.',
            ], 404);
        }

        // Incorrect password (401)
        return response()->json([
            'status' => 'error',
            'message' => 'Incorrect password!',
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
        Auth::guard('admin')->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }




    /* ----------------------------------------------------------------------------------------- */
   
/* public function getProfile(Request $request)
{
    $user = $request->user();

    return response()->json([
        'status' => 'success',
        'user' => $user,
    ]);
}

public function updateProfile(Request $request)
{
    $user = $request->user();

    $request->validate([
        'fname' => 'required|string|max:255',
        'lname' => 'required|string|max:255',
        'allergic_drug' => 'required|string|max:500',
        'my_drug' => 'required|string|max:500',
        'idcard' => 'required|string|max:13|unique:users,idcard,'.$user->id,
    ]);

    $user->update([
        'fname' => $request->fname,
        'lname' => $request->lname,
        'allergic_drug' => $request->allergic_drug,
        'my_drug' => $request->my_drug,
        'idcard' => $request->idcard,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Profile updated successfully',
        'user' => $user,
    ]);
} */
    
}