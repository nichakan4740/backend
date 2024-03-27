<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mysugar;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;


class MysugarController extends Controller
{
    protected $mysugar;

    public function __construct()
    {
        $this->mysugar = new Mysugar();
    }

    
    /*** Display a listing of the resource.*/
    public function index()
    {
        $data = $this->mysugar->with(['user' => function ($query) {
                                     $query->select('id', 'fname', 'lname','idcard');
                                 }])
                               ->paginate(10);
    
        if ($data->isEmpty()) {
            return response()->json(['message' => 'ไม่มีข้อมูล'], 200);
        }
    
        return $data;
    }
    

  public function store(Request $request)
{
    // กำหนดเงื่อนไขในการ validate ข้อมูลก่อนการสร้าง
    $validator = Validator::make($request->all(), [
        'sugarValue' => 'required|numeric',
        'user_id' => 'required',
        'symptom' => 'nullable',
        'note' => 'nullable',
    ]);

    // ตรวจสอบว่าข้อมูลที่ส่งเข้ามาถูกต้องตามเงื่อนไขหรือไม่
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    // สร้าง Mysugar โดยใช้ข้อมูลที่ส่งเข้ามา
    return $this->mysugar->create($request->all());
}








    /** * Display ตาม id */

    public function show(string $id)
    {
        // $mysugar = $this->mysugar->where('user_id', $id)->paginate(15);
    
        $mysugar = $this->mysugar->where('user_id', $id)->get();
        if ($mysugar->isEmpty()) {
            return response()->json(['message' => 'Mysugar not found'], 404);
        }
        return $mysugar;
    }

    

    

    /** * Update the specified resource in storage. */
    public function update(Request $request, string $id)
    {
        $mysugar = $this-> mysugar->find($id);
        $mysugar->update($request->all());
        return  $mysugar;
    }

    /** * Remove the specified resource from storage. */
    public function destroy(string $id)
    {
        $mysugar = $this->mysugar->find($id);
        if (!$mysugar) {
            throw ValidationException::withMessages(['message' => 'Mysugar not found']);
        }
        $mysugar->delete();
        return response()->json(['message' => 'Mysugar deleted successfully']);
    }
}
