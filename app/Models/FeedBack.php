<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedBack extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'feedback';
    protected $fillable=[
        'id_sender',
        'id_teacher',
        'point',
        'description'
    ];
}
