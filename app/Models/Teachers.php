<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teachers extends Model
{
    use HasFactory;

    protected $fillable=[
      'school_id',
      'Citizen_card',
      'education_level',
      'description',
      'time_tutor',
      'status',
      'DistrictID',
      'Certificate'
    ];
}
