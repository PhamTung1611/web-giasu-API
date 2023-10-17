<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teachers;
use App\Http\Requests\TeacherRequest;
use App\Models\User;

class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $teachers = User::select('users.*', 'district.name as DistrictID', 'class_levels.class as class','subjects.name as subject','rank_salaries.value as salary','time_slots.value as time_tutor','schools.name as school_id')
            ->leftJoin('district', 'users.districtID', '=', 'district.id')
            ->leftJoin('class_levels', 'users.class', '=', 'class_levels.id')
            ->leftJoin('subjects', 'users.subject', '=', 'subjects.id')
            ->leftJoin('rank_salaries', 'users.salary', '=', 'rank_salaries.id')
            ->leftJoin('time_slots', 'users.time_tutor', '=', 'time_slots.id')
            ->leftJoin('schools', 'users.school_id', '=', 'schools.id')
            ->where('users.role', 'teacher')
            ->get();
            return response()->json($teachers, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function getTeacherByClass($class)
    {
        $teachers = User::select('users.*', 'district.name as DistrictID', 'class_levels.class as class','subjects.name as subject','rank_salaries.value as salary','time_slots.value as time_tutor','schools.name as school_id')
        ->leftJoin('district', 'users.districtID', '=', 'district.id')
        ->leftJoin('class_levels', 'users.class', '=', 'class_levels.id')
        ->leftJoin('subjects', 'users.subject', '=', 'subjects.id')
        ->leftJoin('rank_salaries', 'users.salary', '=', 'rank_salaries.id')
        ->leftJoin('time_slots', 'users.time_tutor', '=', 'time_slots.id')
        ->leftJoin('schools', 'users.school_id', '=', 'schools.id')
        ->where('users.role', 'teacher')
        ->where('users.class', $class)
        ->get();
        return response()->json($teachers,200);
    }

    public function getDetailTeacher($id){
        $teacher = User::select('users.*', 'district.name as DistrictID', 'class_levels.class as class','subjects.name as subject','rank_salaries.value as salary','time_slots.value as time_tutor','schools.name as school_id')
        ->leftJoin('district', 'users.districtID', '=', 'district.id')
        ->leftJoin('class_levels', 'users.class', '=', 'class_levels.id')
        ->leftJoin('subjects', 'users.subject', '=', 'subjects.id')
        ->leftJoin('rank_salaries', 'users.salary', '=', 'rank_salaries.id')
        ->leftJoin('time_slots', 'users.time_tutor', '=', 'time_slots.id')
        ->leftJoin('schools', 'users.school_id', '=', 'schools.id')
        ->where('users.role', 'teacher')
        ->where('users.id', $id)
        ->get();
        return response()->json($teacher,200);
    }
    /**
     * Show the form for creating a new resource.
     */

    public function store(TeacherRequest $request)
    {
        try {
            // Validate dữ liệu
            $userData = $request->all();
            // Tạo user mới
            $teacher = Teachers::create($userData);
            // Trả về response
            return response()->json($teacher, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => "Thêm không thành công"], 400);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $teacher = Teachers::findOrFail($id);
            return response()->json($teacher, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function update(TeacherRequest $request, string $id)
    {
        try {
            $teacher = Teachers::findOrFail($id);

            $validatedData = $request->all();

            $update = $teacher->update($validatedData);

            if ($update) {
                return response()->json($teacher, 200);
            } else {
                return response()->json(['error' => 'Update không thành công'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        try {
            $teacher = Teachers::findOrFail($id);
            $teacher->delete();
            return response()->json("Delete success", 204);
        } catch (\Exception $e) {
            return response()->json(['error' => "Xóa không thành công "], 400);
        }
    }
   
}
