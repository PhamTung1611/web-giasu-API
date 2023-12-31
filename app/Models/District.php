<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use HasFactory;
//    use SoftDeletes;
    protected $table = 'districts';

    protected $fillable = [
        'name',
        'gso_id',
        'province_id',
        'created_at',
        'updated_at'
    ];

}
