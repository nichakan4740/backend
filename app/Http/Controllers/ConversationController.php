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
}
