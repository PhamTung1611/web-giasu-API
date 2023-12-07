<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Models\ClassLevel;
use App\Models\Connect;
use App\Models\FeedBack;
use App\Models\History;
use App\Models\Job;
use App\Models\RankSalary;
use App\Models\Schools;
use App\Models\Subject;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh sách môn học';
        $subject = Subject::orderBy('id', 'desc')->get();
        if ($request->post() && $request->search) {
            $subject = DB::table('subjects')
                ->where('name', 'like', '%' . $request->search . '%')->get();
        }
        return view('backend.subject.index', compact('subject', 'title'));
    }
    public function ListTeacher($id)
    {
        $title = 'Giáo viên dạy';
        $subject = Subject::find($id);
        if (!$subject) {
            abort(404);
        }
        $teachers = User::where('subject', $id)->where('role', '3')->where('status', '1')->get();
        // dd($teachers);
        return view('backend.subject.teacher', compact('title', 'subject', 'teachers'));
    }
    public function deleteTeacher($id)
        {
            $teacher = User::find($id);
            $teacher->status = 2; 
            $teacher->save();
            return redirect()->route('search_teacher');
        }
        public function deleteUser($id)
        {
            $teacher = User::find($id);
            $teacher->status = 2; 
            $teacher->save();
            return redirect()->route('search_user');
        }
public function DetailUser($id)
{
    $records = User::where('id', $id)->first();

    $newArraySubject = $this->getArrayValues($records->subject, Subject::class);
    $newArrayEducation = $this->getArrayValues($records->education_level, Schools::class);
    $newArrayClass = $this->getArrayValues($records->class_id, ClassLevel::class);
    $newArrayTime = $this->getArrayValues($records->time_tutor_id, TimeSlot::class);

    $newSchool = "";
    $newSalary = "";

    if ($records->school_id != null) {
        $school = Schools::find($records->school_id);
        $newSchool = $school ? $school->name : "";
    }

    if ($records->salary_id != null) {
        $salary = RankSalary::find($records->salary_id);
        $newSalary = $salary ? $salary->name : "";
    }

    // if (!$records->Certificate) {
    //     $records->Certificate = [];
    // } else {
    //     $records->Certificate = json_decode($records->Certificate);
    // }

    $data = [
        'id' => $id,
        'role' => $records->role,
        'gender' => $records->gender,
        'date_of_birth' => $records->date_of_birth,
        'name' => $records->name,
        'email' => $records->email,
        'avatar' => asset('storage/' . $records->avatar),
        'phone' => $records->phone,
        'address' => $records->address,
        'school' => $newSchool,
        'Citizen_card' => $records->Citizen_card,
        'education_level' => $newArrayEducation,
        'class_id' => $newArrayClass,
        'subject' => $newArraySubject,
        'salary_id' => $newSalary,
        'description' => $records->description,
        'time_tutor_id' => $newArrayTime,
        'status' => $records->status,
        'DistrictID' => $records->District_ID,
        // 'Certificate' => $records->Certificate,
        'current_role' => $records->current_role,
        'exp' => $records->exp
    ];
    // dd($data);
    $title = "Hiển thị chi tiết người dùng";
    $history = History::where('id_client', $id)->get();
    $jobs = Job::select('jobs.*', 'user1.id as id_user', 'user1.name as userName', 'user2.id as id_teacher', 'user2.name as teacherName')
        ->leftJoin('users as user1', 'jobs.id_user', '=', 'user1.id')
        ->leftJoin('users as user2', 'jobs.id_teacher', '=', 'user2.id')
        ->where(function ($query) use ($id) {
            $query->where('jobs.id_user', $id)
                ->orWhere('jobs.id_teacher', $id);
        })
        ->get();

    $result = [];
    foreach ($jobs as $job) {
        // Xử lý subjects
        $dataSubject = explode(',', $job->subject);
        $subjectNames = [];
        foreach ($dataSubject as $subjectId) {
            $subject = DB::table('subjects')->where('id', $subjectId)->value('name');
            if ($subject) {
                $subjectNames[] = $subject;
            }
        }
        $job->subject = $subjectNames;

        // Xử lý classes
        $dataClass = explode(',', $job->class);
        $classNames = [];
        foreach ($dataClass as $classId) {
            $class = DB::table('class_levels')->where('id', $classId)->value('class');
            if ($class) {
                $classNames[] = $class;
            }
        }
        $job->class = $classNames;

        $user = DB::table('users')->where('id', $job->id_user)->first();
        $teacher = DB::table('users')->where('id', $job->id_teacher)->first();

        $job->id_user = $user->id;
        $job->id_teacher = $teacher->id;

        $job->userName = $user->name;
        $job->teacherName = $teacher->name;
        $job->subject = implode(', ', $subjectNames);
        $job->class = implode(', ', $classNames);

        $result[] = $job;
    }

    $dataFeedback = FeedBack::select('feedback.*', 'users.name as id_sender')
        // where('idTeacher',$id)
        ->leftJoin('users', 'feedback.id_sender', '=', 'users.id')
        ->where('feedback.id_teacher', $id)
        ->get();
        // dd($result);
    $connect = Connect::all();
    $countJobs = Job::where('id_user',$id)->count();
    $countConnect = Connect::where('id_user',$id)->count();

    return view('backend.users.show', compact('title', 'data','history','result','dataFeedback', 'connect','countConnect','countJobs'));
}
    public function DetailTeacher($id)
    {
        $records = User::where('id', $id)->first();

        $newArraySubject = $this->getArrayValues($records->subject, Subject::class);
        $newArrayEducation = $this->getArrayValues($records->education_level, Schools::class);
        $newArrayClass = $this->getArrayValues($records->class_id, ClassLevel::class);
        $newArrayTime = $this->getArrayValues($records->time_tutor_id, TimeSlot::class);

        $newSchool = "";
        $newSalary = "";

        if ($records->school_id != null) {
            $school = Schools::find($records->school_id);
            $newSchool = $school ? $school->name : "";
        }

        if ($records->salary_id != null) {
            $salary = RankSalary::find($records->salary_id);
            $newSalary = $salary ? $salary->name : "";
        }

        if (!$records->Certificate) {
            $records->Certificate = [];
        } else {
            $records->Certificate = json_decode($records->Certificate);
        }

        $data = [
            'id' => $id,
            'role' => $records->role,
            'gender' => $records->gender,
            'date_of_birth' => $records->date_of_birth,
            'name' => $records->name,
            'email' => $records->email,
            'avatar' => asset('storage/' . $records->avatar),
            'phone' => $records->phone,
            'address' => $records->address,
            'school' => $newSchool,
            'Citizen_card' => $records->Citizen_card,
            'education_level' => $newArrayEducation,
            'class_id' => $newArrayClass,
            'subject' => $newArraySubject,
            'salary_id' => $newSalary,
            'description' => $records->description,
            'time_tutor_id' => $newArrayTime,
            'status' => $records->status,
            'DistrictID' => $records->District_ID,
            'Certificate' => $records->Certificate,
            'current_role' => $records->current_role,
            'exp' => $records->exp
        ];
        // dd($data);
        $title = "Hiển thị chi tiết Giáo viên";
        $history = History::where('id_client', $id)->get();
        $jobs = Job::select('jobs.*', 'user1.id as id_user', 'user1.name as userName', 'user2.id as id_teacher', 'user2.name as teacherName')
            ->leftJoin('users as user1', 'jobs.id_user', '=', 'user1.id')
            ->leftJoin('users as user2', 'jobs.id_teacher', '=', 'user2.id')
            ->where(function ($query) use ($id) {
                $query->where('jobs.id_user', $id)
                    ->orWhere('jobs.id_teacher', $id);
            })
            ->get();

        $result = [];
        foreach ($jobs as $job) {
            // Xử lý subjects
            $dataSubject = explode(',', $job->subject);
            $subjectNames = [];
            foreach ($dataSubject as $subjectId) {
                $subject = DB::table('subjects')->where('id', $subjectId)->value('name');
                if ($subject) {
                    $subjectNames[] = $subject;
                }
            }
            $job->subject = $subjectNames;

            // Xử lý classes
            $dataClass = explode(',', $job->class);
            $classNames = [];
            foreach ($dataClass as $classId) {
                $class = DB::table('class_levels')->where('id', $classId)->value('class');
                if ($class) {
                    $classNames[] = $class;
                }
            }
            $job->class = $classNames;

            $user = DB::table('users')->where('id', $job->id_user)->first();
            $teacher = DB::table('users')->where('id', $job->id_teacher)->first();

            $job->id_user = $user->id;
            $job->id_teacher = $teacher->id;

            $job->userName = $user->name;
            $job->teacherName = $teacher->name;
            $job->subject = implode(', ', $subjectNames);
            $job->class = implode(', ', $classNames);

            $result[] = $job;
        }

        $dataFeedback = FeedBack::select('feedback.*', 'users.name as id_sender')
            // where('idTeacher',$id)
            ->leftJoin('users', 'feedback.id_sender', '=', 'users.id')
            ->where('feedback.id_teacher', $id)
            ->get();
        $connect = Connect::all();
        $countJobs = Job::where('id_teacher',$id)->count();
        $countConnect = Connect::where('id_teacher',$id)->count();
        return view('backend.subject.show', compact('title', 'data','history','result','dataFeedback', 'connect','countJobs','countConnect'));
    }

    private function getArrayValues($field, $modelClass)
    {
        $newArray = [];

        if ($field != null) {
            $makeArray = explode(',', $field);

            foreach ($makeArray as $item) {
                $model = $modelClass::find($item);

                if ($model) {
                    array_push($newArray, $model->name);
                }
            }
        }

        return $newArray;
    }

    public function add(SubjectRequest $request)
    {
        $title = 'Thêm mới môn học';
        if ($request->post()) {
            $params = $request->post();
            $subject = new Subject();
            $subject->name = $request->name;
            $subject->save();
            if ($subject->save()) {
                Session::flash('success', 'Thêm thành công!');
                return redirect()->route('search_subject');
            } else {
                Session::flash('error', 'Thêm không thành công!');
            }
        }
        return view('backend.subject.add', compact('title'));
    }
    public function edit(SubjectRequest $request, $id)
    {
        $title = 'Sửa môn học';
        $subject = Subject::find($id);
        if ($request->isMethod('post')) {
            $update = Subject::where('id', $id)->update($request->except('_token'));
            if ($update) {
                Session::flash('success', 'Sửa thành công');
                return redirect()->route('search_subject');
            } else {
                Session::flash('error', 'Edit subject error');
            }
        }
        return view('backend.subject.edit', compact('title', 'subject'));
    }
    public function delete($id)
    {
        if ($id) {
            $subject = Subject::find($id);
            $deleted = $subject->delete();
            if ($deleted) {
                Session::flash('success', 'Xóa thành công!');
                return redirect()->route('search_subject');
            } else {
                Session::flash('error', 'xoa that bai');
            }
        }
    }
}
