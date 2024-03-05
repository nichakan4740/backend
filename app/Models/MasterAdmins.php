<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MasterAdmins extends Authenticatable
{
 
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
   
    /* สร้างกลุ่มขึ้นมา */
    public function group()
    {
        return $this->belongsToMany('App\Models\Group', 'master_id');
    }


    
   /* ผู้เข้าร่วมกลุ่ม */  
   public function group_member()
   {
       return $this->belongsToMany('App\Models\Group', 'group_participants', 'master_id', 'group_id')->orderBy('updated_at', 'desc');
   }



    /* ข้อความที่ส่งหากัน */
    public function message()
    {
        return $this->hasMany('App\Models\Message','master_id');
    }

    
}
