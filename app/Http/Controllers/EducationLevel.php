<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationLevel extends Controller
{
    public function index(){
        $eduction = Education::all();
        return response()->json($eduction);
    }
}
