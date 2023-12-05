<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connect extends Model
{
    use HasFactory;

    protected $table = 'connect';
    protected $fillable = ['id_user', 'id_job', 'id_teacher', 'note_user', 'status','note_teacher','confirm_user','confirm_teacher'];
}
