<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'admin_id']; 

    // รหัสอื่น ๆ ของโมเดล

    // ในโมเดล Group
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('admin_id'); // ระบุ 'admin_id' เข้าไปใน pivot table
    }
  

}
