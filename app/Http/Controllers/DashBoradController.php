<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashBoradController extends Controller
{
    //
    public function countTeacher(){
        $countTeacher = DB::table('users')->where('role','teacher')->where('status','1')->count();
        $money =  User::find(1);
        dd($money->coin);
    }
}
