<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable implements ShouldQueue , JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard = ["api"];

    protected $fillable = [
        'fname',
        'lname',
        'allergic_drug',
        'my_drug',
        'idcard',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
   //put these methods at the bottom of your class body
  
   public function getJWTIdentifier()
    {
      return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
      return [
        'idcard'=>$this->idcard,
        'fname'=>$this->fname
      ];
    }


    /* เพิ่มการเชื่อมตาราง one to many */
    public function mysugar(): HasMany
    {
        return $this->hasMany(Mysugar::class);
    }


    
    public function drugInformatiom()
    {
        return $this->hasOne(DrugInformation ::class);
    }


    /* ผู้เข้าร่วมกลุ่ม */  
   public function group_member()
   {
       return $this->belongsToMany('App\Models\Group', 'group_participants', 'user_id', 'group_id')->orderBy('updated_at', 'desc');
   }



    /* ข้อความที่ส่งหากัน */
    public function message()
    {
        return $this->hasMany('App\Models\Message','user_id');
    }



}