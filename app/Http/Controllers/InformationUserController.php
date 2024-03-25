<?php

namespace App\Http\Controllers;

use App\Models\InformationUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class InformationUserController extends Controller
{
    protected $information_user;
   
    public function __construct()
    {
        $this->informationUser = new InformationUser();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function updateinfouser(Request $request)
    {
        $validator = Validator::make($request->data, [
            'dob' => 'required',
            'phone' => 'required|string|max:10',
            // 'age' => 'required',
            'address' => 'required|string|max:500',
            'user_id' => 'required',
        ],[],[
            'address' => 'ที่อยู่',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }
    
        try {
            $informationUser = InformationUser::firstornew(['user_id'=>$request->data['user_id']]);
            $informationUser->dob=$request->data['dob'];
            $informationUser->phone=$request->data['phone'];
            $informationUser->address=$request->data['address'];
            $informationUser->user_id=$request->data['user_id'];
            $informationUser->save();

            $User = User::firstornew(['id'=>$request->data['user_id']]);
            $User->fname=$request->data['fname'];
            $User->lname=$request->data['lname'];
            $User->idcard=$request->data['idcard'];
            $User->save();
    
            return response()->json(['message' => 'Information updated successfully', 'InformationUser' => $informationUser, $User], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create Information', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function showinfo(string $id)
    {
        $information = InformationUser::where('user_id', $id)->get();
        if ($information->isEmpty()) {
            return response()->json(['message' => 'Information not found'], 404);
        }
        return $information;
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateInformation(Request $request, InformationUser $informationUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InformationUser $informationUser)
    {
        //
    }

    
}