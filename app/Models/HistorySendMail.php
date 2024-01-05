<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorySendMail extends Model
{
    protected $table = 'history_send_mail';
    protected $fillable = ['id_user','email','type','content'];
    use HasFactory;
}
