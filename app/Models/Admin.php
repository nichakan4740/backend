<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User ;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends User  implements ShouldQueue , JWTSubject
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'professional_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];


        public function getJWTIdentifier()
    {
        return $this->getKey(); // Assuming your admin model has a primary key called "id".
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    /* ----------------------------------------------------------- */
       
   /* ผู้เข้าร่วมกลุ่ม */  
   public function group_member()
   {
       return $this->belongsToMany('App\Models\Group', 'group_participants', 'admin_id', 'group_id')->orderBy('updated_at', 'desc');
   }



    /* ข้อความที่ส่งหากัน */
    public function message()
    {
        return $this->hasMany('App\Models\Message','admin_id');
    }
}
