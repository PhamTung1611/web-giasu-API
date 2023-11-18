<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Ward;
use stdClass;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=[];

        $provinces = Province::all();

       foreach ($provinces as $pro){
           $provinceObject = new stdClass();
           $provinceObject->provinceName = $pro->name;
           $provinceObject->provinceId = $pro->id;


           $districts = District::where('province_id',$pro->id)->get();
           $arrDis = [];
           foreach ($districts as $dis){

               $districtObject = new stdClass();
               $districtObject->districtName = $dis->name;
               $districtObject->districtId = $dis->id;
               $arrDis[]= $districtObject;
               $provinceObject->district=$arrDis;
               $wards = Ward::where('district_id',$dis->id)->get();
               $arrWard=[];
               foreach ($wards as $ward){
                   $wardObject = new stdClass();
                   $wardObject->name = $ward->name;
                   $wardObject->wardId = $ward->id;
                   $arrWard[]= $wardObject;


               }
               $districtObject->ward = $arrWard;
               $data[]= $provinceObject;
           }

       }
        return response()->json($data,200);
    }

    public function getTeacherByDistrict($id){
        // try {
            $teachers = User::select('users.*', 'district.name as DistrictID', 'class_levels.class as class_id','subjects.name as subject','rank_salaries.name as salary_id','time_slots.name as time_tutor_id','schools.name as school_id')
            ->leftJoin('district', 'users.DistrictID', '=', 'district.id')
            ->leftJoin('class_levels', 'users.class_id', '=', 'class_levels.id')
            ->leftJoin('subjects', 'users.subject', '=', 'subjects.id')
            ->leftJoin('rank_salaries', 'users.salary_id', '=', 'rank_salaries.id')
            ->leftJoin('time_slots', 'users.time_tutor_id', '=', 'time_slots.id')
            ->leftJoin('schools', 'users.school_id', '=', 'schools.id')
            ->where('users.role', 'teacher')
            ->where('users.DistrictID',$id)
            ->get();
            $teachers->transform(function ($teacher) {
                if ($teacher->avatar) {
                    $teacher->avatar = 'http://127.0.0.1:8000/storage/' . $teacher->avatar;
                }
                return $teacher;
            });
            return response()->json($teachers, 200);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e], 500);
        // }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
