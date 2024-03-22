<?php

namespace App\Http\Controllers;

use App\Models\InformationUser;
use Illuminate\Http\Request;


class InformationUserController extends Controller
{
    protected $informations_user;
   
    public function __construct()
    {
        $this->InformationUser = new InformationUser();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createinfouser()
    {
        $validator = Validator::make($request->data, [
            'dob' => 'required',
            // 'age' => 'required',
            'address' => 'required',
            'user_id' => 'required',
        ],[],[
            'address' => 'ที่อยู่',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }
    
        try {
            $Information = InformationUser::create([
                'dob' => $request->data['dob'],
                // 'age' => $request->data['age'],
                'address' => $request->data['address'],
                'user_id' => $request->data['user_id'],
            ]);
    
            return response()->json(['message' => 'Information created successfully', 'InformationUser' => $InformationUser], 201);
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
    public function show(string $id)
    {
        $Information = InformationUser::where('user_id', $id)->get();
        if ($Information->isEmpty()) {
            return response()->json(['message' => 'Information not found'], 404);
        }
        return $Information;
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

    // คำนวนอายุ
    // public function index()   
    // {   
    //     $profile   = User::find($this->userid())->profiledetailsHasOne;  //This has Dob field                   
    //     return view('profile.index',['profile' => $profile ]); 
    // }
}
