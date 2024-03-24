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
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Events\LiveChat;
use Pusher\Pusher;


class ConversationController extends Controller

{
    use AuthorizesRequests, ValidatesRequests,DispatchesJobs;

    public function store(Request $request)
{
    
    $message = $request->input('message'); // รับข้อความจาก request
    $admins = Admin::all(); // ดึงข้อมูล admin ทั้งหมด

    // ตั้งค่าตัวแปรสำหรับเก็บข้อมูลการส่งข้อความ
    $messages = [];
    $success = true;

    // ส่งข้อความใหม่ไปยังทุก admin และส่งอีเวนท์ผ่าน Pusher
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

        // โหลดข้อมูลผู้ใช้จากฐานข้อมูล
        $user = User::find($request->input('user_id'));
        // สร้างอาร์เรย์เพื่อเก็บ admin id ทั้งหมด
        $adminIds = [];
        foreach ($admins as $admin) {
            $adminIds[] = $admin->id;
        }
        // กำหนดค่าเริ่มต้นสำหรับ $parentMessageId
        $parentMessageId = null; // หรือค่าอื่นๆ ตามที่คุณต้องการ

        // เพิ่มข้อมูลที่ต้องการส่งไปในอาร์เรย์ของ Pusher
        $data = [
            'text' => $message,
            'fname' => $user->fname, // เพิ่มข้อมูล fname ของผู้ใช้
            'id' =>  $user->id,
            'admin_ids' => $adminIds, // เพิ่ม admin id ทั้งหมดในอาร์เรย์
        ];

        $messages[] = $conversation->message; // เก็บข้อความที่ส่งไปยัง admin ล่าสุด
        Event::dispatch(new NewMessage($conversation)); // เพิ่มบรรทัดนี้
        broadcast(new NewMessage($conversation))->toOthers();   // ส่งอีเวนต์ให้กับผู้ใช้อื่น
    }

    // pusher
    $options = array(
        'cluster' => 'ap1',
        'useTLS' => true
    );

    $pusher = new Pusher(
        'c38b6cfa9a4f7e26bf76',
        '9c01e9989d46534a826a',
        '1766073',
        $options

    );

    // ส่งข้อความด้วย Pusher
    $pusher->trigger('live-chat', 'message', $data);

    // ตรวจสอบสถานะการส่งข้อความ
    if ($success) {
        // ส่งข้อความที่ส่งไปมาในรูปแบบ JSON
        return response()->json([
            'messages' => $messages[0],
            'iduser' => $request->input('user_id') // เพิ่ม iduser ที่ส่งไปด้วย
        ]);
    } else {
        // ส่งข้อความข้อผิดพลาดในกรณีที่ไม่สามารถส่งข้อความไปยังทุก admin ได้
        return response()->json(['error' => 'Unable to send messages'], 500);
    }

  
}

public function Adminrespondsuser(Request $request)
{
    $message = $request->input('message'); // รับข้อความจาก request
    $admin_id = $request->input('admin_id'); // รับ admin_id จาก request

    // ตรวจสอบว่า admin_id ที่รับมาอยู่ในรายชื่อ admin หรือไม่
    $admin = Admin::find($admin_id);
    if (!$admin) {
        return response()->json(['error' => 'Admin not found'], 404);
    }

    // สร้างข้อความใหม่
    $conversation = Conversation::create([
        'message' => $message,
        'user_id' => $request->input('user_id'),
        'admin_id' => $admin->id,
        'parent_id' => $request->input('parent_id'), // เพิ่ม parent_id ที่รับมาจาก request
    ]);

    // ตรวจสอบว่าสร้างข้อความสำเร็จหรือไม่
    if (!$conversation) {
        return response()->json(['error' => 'Failed to create conversation'], 500);
    }

    // โหลดข้อมูลผู้ใช้จากฐานข้อมูล
    $user = User::find($request->input('user_id'));

    // กำหนดค่าเริ่มต้นสำหรับ $parentMessageId
    $parentMessageId = null; // หรือค่าอื่นๆ ตามที่คุณต้องการ

    // เพิ่มข้อมูลที่ต้องการส่งไปในอาร์เรย์ของ Pusher
    $data = [
        'text' => $message,
        'id' =>  $user->id,
        'admin_ids' => [$admin->id], // เพิ่ม admin id ที่ตอบกลับเฉพาะ admin คนนี้
    ];

    // ส่งอีเวนต์ให้กับผู้ใช้อื่น
    broadcast(new NewMessage($conversation))->toOthers();

    // pusher
    $options = array(
        'cluster' => 'ap1',
        'useTLS' => true
    );

    $pusher = new Pusher(
        'c38b6cfa9a4f7e26bf76',
        '9c01e9989d46534a826a',
        '1766073',
        $options
    );

    // ส่งข้อความด้วย Pusher
    $pusher->trigger('live-chat', 'message', $data);

    // ส่งข้อความที่ส่งไปมาในรูปแบบ JSON
    return response()->json([
        'message' => $message,
        'user_id' => $request->input('user_id'),
        'admin_id' => $admin->id
    ]);
}

}
