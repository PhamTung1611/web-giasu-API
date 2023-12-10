<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'subjects';
    protected $fillable = [
        'name'
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'subject');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'subject');
    }
}
