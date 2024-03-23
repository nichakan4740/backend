<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationUser extends Model
{
    use HasFactory;
    protected $table = 'informations_user'; // ระบุชื่อตารางที่ถูกต้อง
    protected $fillable = [
        'dob', 
        // 'age', 
        'address', 
        'user_id'];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function getAge()
    // {
    //     $this->birthdate->diff($this->attributes['dob'])
    //     ->format('%y years, %m months and %d days');
    // }

}
