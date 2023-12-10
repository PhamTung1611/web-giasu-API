<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassLevel extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'class_levels';
    protected $fillable = [
        'class',
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'class_id');
    }
    public function jobs()
    {
        return $this->hasMany(Job::class, 'class');
    }
}
