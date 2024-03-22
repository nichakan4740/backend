<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Conversation;

class NewMessage
{
    use Dispatchable, SerializesModels;

    public $conversation;

    /**
     * Create a new event instance.
     *
     * @param Conversation $conversation
     */
    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        // ตรวจสอบว่า $this->conversation มีค่าหรือไม่ก่อนที่จะเรียกใช้ฟิลด์ group_id
        if ($this->conversation->group_id) {
            return new PrivateChannel('groups.' . $this->conversation->group_id);
        }

        // ถ้าไม่มี group_id ให้ส่งไปยัง private channel แบบกำหนดเอง หรือส่งไปยังอื่น ๆ ตามที่คุณต้องการ
        return new PrivateChannel('custom-channel');
    }
}
