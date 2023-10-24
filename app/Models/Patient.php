<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

protected $fillable =[
    'f_name',
    'm_name',
    'l_name',
    'gender',
    'occupation',
    'phisical_address',
    'phone',
    'DOB',
    'kins_name',
    'kins_mobile',
    'createdBy'
];

public function user(){
  return $this->belongsTo(User::class, 'createdBy');
}
}
