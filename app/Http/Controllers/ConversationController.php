<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Events\NewMessage;
class ConversationController extends Controller
{
    public function store(Request $request)
    {
        // รับ ID ของ admin จาก request
        $adminId = $request->input('admin_id');
    
        // สร้างข้อความใหม่
        $conversation = Conversation::create([
            'message' => $request->input('message'),
            'group_id' => $request->input('group_id'),
            'user_id' => $request->input('user_id'),
            'admin_id' => $adminId, 
        ]);
    
        // โหลดข้อมูลผู้ใช้ที่ส่งข้อความ
        $conversation->load('user');
    
        // ส่งอีเวนต์ให้กับผู้ใช้อื่น
        broadcast(new NewMessage($conversation))->toOthers();
    
        return $conversation;
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
        'group_id' => $conversation->group_id,
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

    // ส่งอีเวนต์ให้กับผู้ใช้อื่น
    broadcast(new NewMessage($reply))->toOthers();

    return $reply;
}





}
