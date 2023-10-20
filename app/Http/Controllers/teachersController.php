<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teachers;
use App\Http\Requests\TeacherRequest;
use App\Http\Requests\UserRequest;
use App\Models\ClassLevel;
use App\Models\District;
use App\Models\RankSalary;
use App\Models\Schools;
use App\Models\Subject;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $teachers = User::select('users.*', 'district.name as DistrictID', 'class_levels.class as class', 'subjects.name as subject', 'rank_salaries.name as salary', 'time_slots.name as time_tutor', 'schools.name as school_id')
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
        $teachers = User::select('users.*', 'district.name as DistrictID', 'class_levels.class as class', 'subjects.name as subject', 'rank_salaries.name as salary', 'time_slots.name as time_tutor', 'schools.name as school_id')
            ->leftJoin('district', 'users.districtID', '=', 'district.id')
            ->leftJoin('class_levels', 'users.class', '=', 'class_levels.id')
            ->leftJoin('subjects', 'users.subject', '=', 'subjects.id')
            ->leftJoin('rank_salaries', 'users.salary', '=', 'rank_salaries.id')
            ->leftJoin('time_slots', 'users.time_tutor', '=', 'time_slots.id')
            ->leftJoin('schools', 'users.school_id', '=', 'schools.id')
            ->where('users.role', 'teacher')
            ->where('users.class', $class)
            ->get();
        return response()->json($teachers, 200);
    }

    public function getDetailTeacher($id)
    {
        $teacher = User::select('users.*', 'district.name as DistrictID', 'class_levels.class as class', 'subjects.name as subject', 'rank_salaries.name as salary', 'time_slots.name as time_tutor', 'schools.name as school_id')
            ->leftJoin('district', 'users.districtID', '=', 'district.id')
            ->leftJoin('class_levels', 'users.class', '=', 'class_levels.id')
            ->leftJoin('subjects', 'users.subject', '=', 'subjects.id')
            ->leftJoin('rank_salaries', 'users.salary', '=', 'rank_salaries.id')
            ->leftJoin('time_slots', 'users.time_tutor', '=', 'time_slots.id')
            ->leftJoin('schools', 'users.school_id', '=', 'schools.id')
            ->where('users.role', 'teacher')
            ->where('users.id', $id)
            ->first();
        return response()->json($teacher, 200);
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

    public function getAllTeacher()
    {
        $title = "List";
        $teachers = User::where('users.role', 'teacher')
            ->get();
        return view('backend.teacher.index', compact('teachers', 'title'));
    }

    public function addNewTeacher(TeacherRequest $request)
    {
        $title = "List";
        $district = District::all();
        $school = Schools::all();
        $subject = Subject::all();
        $class = ClassLevel::all();
        $salary = RankSalary::all();
        $timeTutor = TimeSlot::all();

        if($request->isMethod('post')){
            $params = $request->post();
            $teacher = new User();
            $teacher->role = $request->role;
            $teacher->name = $request->name;
            $teacher->email = $request->email;
            $teacher->password = $request->password;
            $teacher->avatar = $request->avatar;
            $teacher->phone = $request->phone;
            $teacher->address = $request->address;
            $teacher->school_id = $request->school_id;
            $teacher->Citizen_card = $request->Citizen_card;
            $teacher->education_level = $request->education_level;
            $teacher->class = $request->class;
            $teacher->subject = $request->subject;
            $teacher->salary = $request->salary;
            $teacher->description = $request->description;
            $teacher->time_tutor = $request->time_tutor;
            $teacher->status = $request->status;
            $teacher->DistrictID = $request->DistrictID;
            $teacher->Certificate = $request->Certificate;
            $teacher->save();
            if($teacher->save()) {
                Session::flash('success', 'Thêm thành công!');
                return redirect()->route('search_teacher');
            }
            else {
                Session::flash('error', 'Thêm không thành công!');
            }
        }

        return view('backend.teacher.add', compact('district', 'title','school', 'subject','class', 'salary','timeTutor'));
    }
    public function updateTeacher(UserRequest $request,$id){
        $title = "Edit Teacher";
        $district = District::all();
        $school = Schools::all();
        $subject = Subject::all();
        $class = ClassLevel::all();
        $salary = RankSalary::all();
        $timeTutor = TimeSlot::all();
        $teacher = User::findOrFail($id);
        // dd($teacher);
        if($request->isMethod('post')){
            $update = User::where('id', $id)->update($request->except('_token'));
            if($update){
                Session::flash('success', 'Edit teacher success');
                return redirect()->route('search_teacher');
            }else{
                Session::flash('error', 'Edit subject error');
            }
        }
        return view('backend.teacher.edit', compact('teacher', 'title','district','school', 'subject','class', 'salary','timeTutor'));
    }
}
