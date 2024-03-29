<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'user_id', 'admin_id', 'parent_id','is_reply'];


    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
