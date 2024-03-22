<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Events\LiveChat;
use Pusher\Pusher;


class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests,DispatchesJobs;
    public function TestChat()
    {
        $text = 'wow';
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

        // ส่งอีเวนท์ LiveChat ผ่าน Pusher
        $pusher->trigger('live-chat', 'message', ['text' => $text]);

        return 'Send Message Success';
    }


    public function checkDataForUser($id)
    {
        // เรียกใช้งานฟังก์ชัน hasDataForUser() จาก Model
        $hasData = DrugInformation::hasDataDrug($id);
        
        // ส่งผลลัพธ์กลับไปยัง Frontend ในรูปแบบ JSON
        return response()->json(['hasData' => $hasData]);
    }

}


