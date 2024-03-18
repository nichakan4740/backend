<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Events\NewMessage;
use App\Models\User; // นำเข้า User model


class ConversationController extends Controller
{
    public function store(Request $request)
    {
        // รับ ID ของ admin จาก request
        $adminId = $request->input('admin_id');
    
        // สร้างข้อความใหม่
        $conversation = Conversation::create([
            'message' => $request->input('message'),
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




    /* ดูว่าใครคุยกับใคร  */
    private function findConversation($userId, $adminId) {
        $conversation = Conversation::where('user_id', $userId)
                                     ->where('admin_id', $adminId)
                                     ->first();
        if ($conversation) {
            // ถ้ามี conversation ระหว่าง user_id กับ admin_id ที่กำหนด
            if ($userId) {
                // ในกรณีที่ user_id ไม่ใช่ null
                // คุณสามารถดำเนินการต่อได้ตามต้องการ เช่น โหลดข้อมูลผู้ใช้ที่ส่งข้อความ
                $conversation->load('user');
            } elseif ($adminId) {
                // ในกรณีที่ admin_id ไม่ใช่ null
                // คุณสามารถดำเนินการต่อได้ตามต้องการ เช่น โหลดข้อมูล admin
                $conversation->load('admin');
            }
    
            // คุณสามารถดำเนินการอื่น ๆ ต่อไปได้ตามต้องการ
        } else {
            // ถ้าไม่พบ conversation ระหว่าง user_id กับ admin_id ที่กำหนด
            // คุณสามารถจัดการในกรณีนี้ตามต้องการ
        }
    
        return $conversation; // คืนค่า conversation ที่พบ (หรือ null หากไม่พบ)
    }
    
}
