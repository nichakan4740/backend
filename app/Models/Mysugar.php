<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Pagination\Paginator;


class Mysugar extends Model
{
    use HasFactory;
    protected $fillable = [    
        'sugarValue',
        'symptom',
        'note',
        'user_id'
       /*  'patientIdNumber' */
    ];


    
     /* เพิ่มการเชื่อมตาราง one to many */
     public function user()
    {
        return $this->belongsTo(User::class);
    }

}
