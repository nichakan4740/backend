<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo('App\Models\Group', 'group_id');
    }

    /* ----------------------------------------------------------------------------- */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    

    
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'admin_id');
    }



    public function masteradmin()
    {
        return $this->belongsTo('App\Models\MasterAdmin', 'master_id');
    }

    /* -------------------------------------------------------------------------------- */

    public function getDateTimeAttribute()
    {
        //we get the date and the time, this will return an array
        $dateAndTime = explode(' ', $this->created_at);

        $date = date('d-M-Y', strtotime($dateAndTime[0]));

        $time = date('H:i', strtotime($dateAndTime[1]));

        return "{$date} {$time}";
    }
}
