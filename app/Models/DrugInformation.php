<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrugInformation extends Model
{
    use HasFactory;

    protected $table = 'drug_informations'; // ระบุชื่อตารางที่ถูกต้อง
    protected $fillable = [
        'allergic_drug', 
        'my_drug', 
        'user_id'];




    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
