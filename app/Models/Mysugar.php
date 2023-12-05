<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mysugar extends Model
{
    use HasFactory;
    protected $fillable = [    
        'sugarValue',
        'symptom',
        'note'
       /*  'patientIdNumber' */
    ];
}
