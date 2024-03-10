<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Group; 
use App\Models\User; 
use App\Events\GroupCreated; // เพิ่มการ import Event

class GroupController extends Controller
{



    # GroupController.php
    public function store(Request $request)
    {
        // ตรวจสอบว่าค่า id ของผู้ใช้ถูกส่งมาหรือไม่
        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array', // รับ user_ids จาก request และต้องเป็น array
            'user_ids.*' => 'required|integer', // ต้องเป็นตัวเลขทุกค่าใน array
            'name' => 'required|string', // ต้องระบุชื่อกลุ่ม
            'admin_id' => 'required|array', // รับ admin_id และต้องเป็น array
            'admin_id.*' => 'required|integer', // ต้องเป็นตัวเลขทุกค่าใน array
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400); // ส่งกลับข้อผิดพลาด 400 Bad Request ถ้ามีข้อผิดพลาดในข้อมูลที่ส่งมา
        }
    
        // สร้างกลุ่มใหม่
        $group = Group::create([
            'name' => $request->input('name'),
        ]);
    
        // เพิ่มผู้ใช้เข้ากลุ่มโดยระบุ admin_id โดยวนลูปผ่าน admin_ids
        foreach ($request->input('admin_id') as $admin_id) {
            $group->users()->attach($request->input('user_ids'), ['admin_id' => $admin_id]);
        }
    
        return $group;
    }
    
    
    
}
