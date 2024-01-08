<?php

namespace App\Http\Controllers;

use App\Models\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        return response()->json('success');
    }

    public function finalResponse($message = "success",
    $statusCode = 200,
    $data = null,
    $pagnation = null,
    $errors = null) : JsonResponse
{
return response()->json([
"message" => $message,
"data" => $data,
'pagination' => $pagnation,
'errors' => $errors
],$statusCode);
}


    public function loginAdmin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = auth()->guard('admin')->attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'Some Error Message'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }
        return $this->finalResponse($token);
    }


}