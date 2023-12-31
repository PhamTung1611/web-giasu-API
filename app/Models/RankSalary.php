<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class RankSalary extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'rank_salaries';

    protected $fillable = [
        'name'
    ];
}
