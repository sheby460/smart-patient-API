<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    protected $fillable =[
       'clinic_name',
       'clinic_status',
       'createdBy',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'createdBy');
    }
}
