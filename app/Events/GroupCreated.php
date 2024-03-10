<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $adminId; // เพิ่ม property สำหรับเก็บ id ของ admin

    /**
     * Create a new event instance.
     *
     * @param int $adminId
     */
    public function __construct($adminId)
    {
        $this->adminId = $adminId; // กำหนดค่า id ของ admin
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        $channels = [];

        // ใส่ id ของ admin เข้าไปใน channels
        array_push($channels, new PrivateChannel('users.' . $this->adminId));

        // ใส่ id ของผู้ใช้ในกลุ่มเข้าไปใน channels
        foreach ($this->group->users as $user) {
            array_push($channels, new PrivateChannel('users.' . $user->id));
        }

        return $channels;
    }
}
