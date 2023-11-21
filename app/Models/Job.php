<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;
    // protected $fillable = [
    //     'title', 'name', 'address', 'date_time', 'phone', 'email', 'subjects_need', 'education_level', 'salary', 'requirements'
    // ];
    protected $table = 'jobs';
    protected $fillable = ['idUser', 'subject', 'idTeacher', 'class', 'status','description'];
}
