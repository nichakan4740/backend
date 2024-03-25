<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationUser extends Model
{
    use HasFactory;
    protected $table = 'information_user'; // ระบุชื่อตารางที่ถูกต้อง
    protected $fillable = [
        'dob', 
        'phone',
        // 'age', 
        'address', 
        'user_id'];



    public function user()
    {
        return $this->belongsTo(User::class);
    }



}