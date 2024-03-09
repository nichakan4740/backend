<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConversationController extends Controller
{

        # ConversationController.php
    
      /*   public function store()
        {
            $conversation = Conversation::create([
                'message' => request('message'),
                'group_id' => request('group_id'),
                'user_id' => auth()->user()->id,
            ]);
    
            return $conversation->load('user');
        } */
        public function store()
        {
            $conversation = Conversation::create([
                'message' => request('message'),
                'group_id' => request('group_id'),
                'user_id' => auth()->user()->id,
            ]);
    
            $conversation->load('user');
    
            broadcast(new NewMessage($conversation))->toOthers();
    
            return $conversation->load('user');
        }
    
    
    
    
}
