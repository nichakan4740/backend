<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Events\NewMessage;
use App\Models\User; 
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class ConversationController extends Controller
{
    public function store(Request $request)
{
    // รับข้อความจาก request
    $message = $request->input('message');
    
    // ดึงข้อมูล admin ทั้งหมด
    $admins = Admin::all();
    
    // ตั้งค่าตัวแปรสำหรับเก็บข้อมูลการส่งข้อความ
    $messages = [];
    $success = true;

    // สร้างข้อความใหม่และส่งไปยังทุก admin
    foreach ($admins as $admin) {
        // สร้างข้อความใหม่
        $conversation = Conversation::create([
            'message' => $message,
            'user_id' => $request->input('user_id'),
            'admin_id' => $admin->id, 
        ]);
    
        // ตรวจสอบว่าสร้างข้อความสำเร็จหรือไม่
        if (!$conversation) {
            $success = false;
            break; // หยุดการทำงานเมื่อเกิดข้อผิดพลาด
        }

        // เก็บข้อความที่ส่งไปยัง admin ล่าสุด
        $messages[] = $conversation->message;


        Event::dispatch(new NewMessage($conversation)); // เพิ่มบรรทัดนี้
    
        // ส่งอีเวนต์ให้กับผู้ใช้อื่น
        broadcast(new NewMessage($conversation))->toOthers();
    }

    // ตรวจสอบสถานะการส่งข้อความ
    if ($success) {
        // ส่งข้อความที่ส่งไปมาในรูปแบบ JSON
        return response()->json(['messages' => $messages[0]]);
    } else {
        // ส่งข้อความข้อผิดพลาดในกรณีที่ไม่สามารถส่งข้อความไปยังทุก admin ได้
        return response()->json(['error' => 'Unable to send messages'], 500);
    }
}




    /* ตอบกลับ */
    public function reply(Request $request, Conversation $conversation)
    {
        // รับ ID ของผู้ใช้หรือ admin ที่ตอบกลับ
        $userId = $request->input('user_id');
        $adminId = $request->input('admin_id');

        // สร้างข้อความตอบกลับ
        $reply = Conversation::create([
            'message' => $request->input('message'),
            'user_id' => $userId,
            'admin_id' => $adminId,
            'parent_id' => $conversation->id, // เพิ่ม parent_id เพื่อระบุว่าเป็นการตอบกลับข้อความแชทเดิม
        ]);

        // โหลดข้อมูลผู้ใช้ที่ส่งข้อความ
        if ($userId) {
            $reply->load('user');
        } elseif ($adminId) {
            $reply->load('admin');
        }

        Event::dispatch(new NewMessage($reply));
        // ส่งอีเวนต์ให้กับผู้ใช้อื่น
        broadcast(new NewMessage($reply))->toOthers();

        return $reply;
    }



/* ------------------------------------------------------------------------------------------------ */
    /* show ข้อความ */
    public function showMessageUser(Request $request)
    {
        // รับ ID ของ admin จาก request
        $adminId = $request->input('admin_id');
        
        // ค้นหาข้อความทั้งหมดที่ถูกส่งจากผู้ใช้ที่ไม่ใช่ admin นี้
        $messages = Conversation::where('admin_id', '!=', $adminId)
                                 ->with('user' ) // โหลดข้อมูลของผู้ใช้ที่ส่งข้อความ
                                 ->get();
    
        // คืนค่าข้อความในรูปแบบ JSON
        return response()->json(['messages' => $messages]);
    }

    

    /* แสดงข้อความโดยใช้ admin_id */
      public function showMessageUserWithAdminId(Request $request, $adminId)
    {
    // ค้นหาข้อความทั้งหมดที่ถูกส่งโดยผู้ใช้ที่ไม่ใช่ admin นี้และส่งไปยัง admin ที่มี admin_id ที่ระบุ
    $messages = Conversation::where('admin_id', $adminId)
                             ->with('user') // โหลดข้อมูลของผู้ใช้ที่ส่งข้อความ
                             ->get();

    // คืนค่าข้อความในรูปแบบ JSON
    return response()->json(['messages' => $messages]);
}

      
    

    /* ----------------------------------------------------------- */
    
    public function deleteMessage(Request $request, $messageId)
    {
        // ค้นหาข้อความที่ต้องการลบ
        $message = Conversation::findOrFail($messageId);
    
        // ลบข้อความ
        $message->delete();
        
        // ส่งข้อความยืนยันการลบ
        return response()->json(['message' => 'Message deleted successfully']);
    }
    

    
}
