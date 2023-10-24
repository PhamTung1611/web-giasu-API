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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class TeachersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $teachers = User::select('users.*', 'district.name as DistrictID', 'class_levels.class as class_id', 'subjects.name as subject', 'rank_salaries.name as salary_id', 'time_slots.name as time_tutor_id', 'schools.name as school_id')
                ->leftJoin('district', 'users.districtID', '=', 'district.id')
                ->leftJoin('class_levels', 'users.class_id', '=', 'class_levels.id')
                ->leftJoin('subjects', 'users.subject', '=', 'subjects.id')
                ->leftJoin('rank_salaries', 'users.salary_id', '=', 'rank_salaries.id')
                ->leftJoin('time_slots', 'users.time_tutor_id', '=', 'time_slots.id')
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
        $teachers = User::select('users.*', 'district.name as DistrictID', 'class_levels.class as class_id', 'subjects.name as subject', 'rank_salaries.name as salary_id', 'time_slots.name as time_tutor_id', 'schools.name as school_id')
            ->leftJoin('district', 'users.districtID', '=', 'district.id')
            ->leftJoin('class_levels', 'users.class_id', '=', 'class_levels.id')
            ->leftJoin('subjects', 'users.subject', '=', 'subjects.id')
            ->leftJoin('rank_salaries', 'users.salary_id', '=', 'rank_salaries.id')
            ->leftJoin('time_slots', 'users.time_tutor_id', '=', 'time_slots.id')
            ->leftJoin('schools', 'users.school_id', '=', 'schools.id')
            ->where('users.role', 'teacher')
            ->where('users.class_id', $class)
            ->get();
        return response()->json($teachers, 200);
    }

    public function getDetailTeacher($id)
    {
        $teachers = User::select('users.*', 'district.name as DistrictID', 'class_levels.class as class_id', 'subjects.name as subject', 'rank_salaries.name as salary_id', 'time_slots.name as time_tutor_id', 'schools.name as school_id')
            ->leftJoin('district', 'users.districtID', '=', 'district.id')
            ->leftJoin('class_levels', 'users.class_id', '=', 'class_levels.id')
            ->leftJoin('subjects', 'users.subject', '=', 'subjects.id')
            ->leftJoin('rank_salaries', 'users.salary_id', '=', 'rank_salaries.id')
            ->leftJoin('time_slots', 'users.time_tutor_id', '=', 'time_slots.id')
            ->leftJoin('schools', 'users.school_id', '=', 'schools.id')
            ->where('users.role', 'teacher')
            ->where('users.id', $id)
            ->first();
        return response()->json($teachers, 200);
    }
    /**
     * Show the form for creating a new resource.
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
        $teachers = User::where('users.role', 'teacher')->get();
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

        if ($request->isMethod('post')) {
            // $params = $request->post();
            $params = $request->except('_token');
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $params['avatar'] = uploadFile('hinh', $request->file('avatar'));
            }
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
            $teacher->fill($params);
            $teacher->save();
            if ($teacher->save()) {
                Session::flash('success', 'Thêm thành công!');
                return redirect()->route('search_teacher');
            } else {
                Session::flash('error', 'Thêm không thành công!');
            }
        }

        return view('backend.teacher.add', compact('district', 'title', 'school', 'subject', 'class', 'salary', 'timeTutor'));
    }
    public function updateTeacher(UserRequest $request, $id)
    {
        $title = "Edit Teacher";
        $district = District::all();
        $school = Schools::all();
        $subject = Subject::all();
        $class = ClassLevel::all();
        $salary = RankSalary::all();
        $timeTutor = TimeSlot::all();
        $teacher = User::findOrFail($id);
        // dd($teacher);
        if ($request->isMethod('post')) {
            $params = $request->except('_token');
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $deleteImage = Storage::delete('/public/' . $teacher->avatar);
                if ($deleteImage) {
                    $params['avatar'] = uploadFile('hinh', $request->file('avatar'));
                }
            }
            // $update = User::where('id', $id)->update($request->except('_token'));
            $update = User::where('id', $id)->update($params);
            if ($update) {
                Session::flash('success', 'Edit teacher success');
                return redirect()->route('search_teacher');
            } else {
                Session::flash('error', 'Edit subject error');
            }
        }
        return view('backend.teacher.edit', compact('teacher', 'title', 'district', 'school', 'subject', 'class', 'salary', 'timeTutor'));
    }

    public function getTeacherByFilter(Request $request)
    {
        // dd($request);
        $query = User::with('district:id,name', 'subject:id,name', 'school:id,name', 'class_levels:id,class', 'timeSlot:id,name')->where('role', 'teacher');
        // $query = User::query();

        if ($request->has('DistrictID')) {
            $query->where('DistrictID', $request->input('DistrictID'));
        }

        if ($request->has('subject')) {
            $query->where('subject', $request->input('subject'));
        }

        if ($request->has('class')) {
            $query->where('class', $request->input('class'));
        }
        $users = $query->get();
        if ($users) {
            return response()->json($users, 200);
        } else {
            return response()->json(['message' => "Not Found"], 404);
        }
    }
}
