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
        // รับข้อความจาก request
        $message = $request->input('message');
    
        // ดึงข้อมูล admin ทั้งหมด
        $admins = Admin::all();
    
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

            // เพิ่มข้อมูลที่ต้องการส่งไปในอาร์เรย์ของ Pusher
            $data = [
           'text' => $message,
           'fname' => $user->fname, // เพิ่มข้อมูล fname ของผู้ใช้
           'id' =>  $user->id,
           'admin_ids' => $adminIds, // เพิ่ม admin id ทั้งหมดในอาร์เรย์

        ];

            // เก็บข้อความที่ส่งไปยัง admin ล่าสุด
            $messages[] = $conversation->message;
    
            Event::dispatch(new NewMessage($conversation)); // เพิ่มบรรทัดนี้
    
            // ส่งอีเวนต์ให้กับผู้ใช้อื่น
            broadcast(new NewMessage($conversation))->toOthers();
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
            return response()->json(['messages' => $messages[0]]);
        } else {
            // ส่งข้อความข้อผิดพลาดในกรณีที่ไม่สามารถส่งข้อความไปยังทุก admin ได้
            return response()->json(['error' => 'Unable to send messages'], 500);
        }
    }
    /* -------------------------------------------------------------------------------------------------------- */


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
  
}
