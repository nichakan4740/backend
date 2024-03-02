<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Events\LiveChat;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public  function TestChat(){
        $text = 'wow';
        event(new LiveChat($text));
//        DB::table('log_chat')->insert([
//            'text' => $text
//        ]);
        return 'Send Message Success';
    }
}
