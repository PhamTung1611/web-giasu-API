<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connect extends Model
{
    use HasFactory;

    protected $table = 'connect';
    protected $fillable = ['idUser', 'idJob', 'idTeacher', 'noteUser', 'status','noteTeacher','confirmUser','confirmTeacher'];
}
