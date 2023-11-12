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
                $teachers->transform(function ($teacher) {
                    if ($teacher->avatar) {
                        $teacher->avatar = 'http://127.0.0.1:8000/storage/' . $teacher->avatar;
                    }
                    if ($teacher->Certificate ){
                        $teacher->Certificate = json_decode($teacher->Certificate);
                    }
                    return $teacher;
                });
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

            $teachers->transform(function ($teacher) {
                if ($teacher->avatar) {
                    $teacher->avatar = 'http://127.0.0.1:8000/storage/' . $teacher->avatar;
                }
                if ($teacher->Certificate ){
                    $teacher->Certificate = json_decode($teacher->Certificate);
                }
                return $teacher;
            });
        return response()->json($teachers, 200);
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
        $view=1;
        $teachers = User::where('role', 'teacher')->whereIn('status', [0, 1])->get();
        return view('backend.teacher.index', compact('teachers', 'title','view'));
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
            $teacher->password =  Hash::make($request->password);
            $teacher->avatar = $request->avatar;
            $teacher->phone = $request->phone;
            $teacher->address = $request->address;
            $teacher->school_id = $request->school_id;
            $teacher->Citizen_card = $request->Citizen_card;
            $teacher->education_level = $request->education_level;
            $teacher->class_id = $request->class;
            $teacher->subject = $request->subject;
            $teacher->salary_id = $request->salary;
            $teacher->description = $request->description;
            $teacher->time_tutor_id = $request->time_tutor;
            $teacher->status = $request->status;
            $teacher->DistrictID = $request->DistrictID;
            if ($request->hasFile('Certificate')) {
                $certificates = [];

                foreach ($request->file('Certificate') as $file) {
                    if ($file->isValid()) {
                        $certificates[] = uploadFile('hinh', $file);
                    }
                }
                $teacher->Certificate = json_encode($certificates); // Lưu đường dẫn của các ảnh trong một mảng JSON
            } else {
                $teacher->Certificate = null;
            }
            $teacher->date_of_birth = $request->date_of_birth;
            $teacher->gender = $request->gender;
//            $teacher->fill($params);
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
            if ($request->hasFile('Certificate')) {
                    if ($params['Certificatelast']!= null){
                        $imagelast = json_decode($params['Certificatelast']);
                        foreach ($imagelast as $i){
                            Storage::delete('/public/' . $i);
                        }
                    }

                $certificates = [];

                foreach ($request->file('Certificate') as $file) {
                    if ($file->isValid()) {
                        $certificates[] = uploadFile('hinh', $file);
                    }
                }
                $params['Certificate'] = json_encode($certificates); // Lưu đường dẫn của các ảnh trong một mảng JSON

            }else{
                $params['Certificate']= $params['Certificatelast'];
            }

            unset($params['Certificatelast']);
            $data = $params;
            if($data['gender']== 1 ){
                $data['gender']='Nam';
            }else{
                $data['gender']='Nữ';
            }
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $deleteImage = Storage::delete('/public/' . $teacher->avatar);
                if ($deleteImage) {
                    $data['avatar'] = uploadFile('hinh', $request->file('avatar'));
                }
            }

            $data['password'] =  Hash::make($data['password']);

            // $update = User::where('id', $id)->update($request->except('_token'));
            $update = User::where('id', $id)->update($data);
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
        $query = User::with('district:id,name', 'subject:id,name', 'school:id,name', 'class_levels:id,class', 'timeSlot:id,name')->where('role', 'teacher');

        if ($request->has('DistrictID')) {
            $query->where('DistrictID', $request->input('DistrictID'));
        }

        if ($request->has('subject')) {
            $query->where('subject', $request->input('subject'));
        }

        if ($request->has('class')) {
            $query->where('class_id', $request->input('class'));
        }

        $records = $query->get();

        $processedRecords = $records->map(function ($record) {
            $newArraySubject = [];
            if ($record->subject != null) {
                $makeSubject = explode(',', $record->subject);
                foreach ($makeSubject as $item) {
                    $subjectNew = Subject::find($item);
                    if ($subjectNew) {
                        array_push($newArraySubject, $subjectNew->name);
                    }
                }
            }

            $newArrayClass = [];
            if ($record->class_id != null) {
                $makeClass = explode(',', $record->class_id);
                foreach ($makeClass as $item) {
                    $classNew = ClassLevel::find($item);
                    if ($classNew) {
                        array_push($newArrayClass, $classNew->class);
                    }
                }
            }
            if ($record->Certificate ){
                $record->Certificate = json_decode($record->Certificate);
            }

            // Thêm các xử lý khác cho các trường dữ liệu khác

            return [
                'id' => $record->id, // Thêm id của bản ghi vào mảng
                'role' => $record->role,
                'gender' => $record->gender,
                'date_of_birth' => $record->date_of_birth,
                'name' => $record->name,
                'email' => $record->email,
                'avatar' => 'http://127.0.0.1:8000/storage/' . $record->avatar,
                'phone' => $record->phone,
                'address' => $record->address,
                'school_id' => $record->school_id ? Schools::find($record->school_id)->name : null,
                'Citizen_card' => $record->Citizen_card,
                'education_level' => $record->education_level,
                'class_id' => $newArrayClass,
                'subject' => $newArraySubject,
                'salary_id' => $record->salary_id ? RankSalary::find($record->salary_id)->name : null,
                'description' => $record->description,
                'time_tutor_id' => [], // Thêm xử lý cho 'time_tutor_id' nếu cần
                'status' => $record->status,
                'DistrictID' => $record->DistrictID ? District::find($record->DistrictID)->name : null,
                'Certificate' => $record->Certificate,
            ];
        });

        return response()->json($processedRecords, 200);
    }
    public function delete($id,$view){

        if($id){
            $user = User::find($id);
            $deleted = $user->delete();
            if($deleted){

                if($view==1){
                    Session::flash('success','success');
                    return redirect()->route('search_teacher');
                }else{
                    Session::flash('success','success');
                    return redirect()->route('waiting');
                }
            }else{
                Session::flash('error','error');
            }
        }
    }

}
