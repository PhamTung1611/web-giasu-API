<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SubjectController extends Controller
{
    public function index(Request $request){
        $title = 'Danh sách môn học';
        $subject = Subject::all();
        if ($request->post() && $request->search) {
            $subject = DB::table('subjects')
                ->where('name', 'like', '%'.$request->search.'%')->get();
        }
        return view('backend.subject.index', compact('subject', 'title'));
    }
    public function ListTeacher($id){
        $title = 'Giáo viên dạy';
        $subject = Subject::find($id);
        if (!$subject) {
            abort(404);
        }
        $teachers = User::where('subject', $id)->get();
        return view('backend.subject.teacher',compact('title', 'subject', 'teachers'));
    }
    public function DetailTeacher(Request $request, $id) {
        $records = User::where('id', $id)->first();
        $newArraySubject = [];
        if ($records->subject != null) {
            $makeSubject = explode(',', $records->subject);
            foreach ($makeSubject as $item) {
                $subjectNew = Subject::find($item);
                array_push($newArraySubject, $subjectNew->name);
            }
        }
        $newArrayEduaction = [];
        if ($records->education_level != null) {
            $makeEducation = explode(',', $records->education_level);
            foreach ($makeEducation as $item) {
                $educationNew = Subject::find($item);
                array_push($newArrayEduaction, $educationNew->name);
            }
        }
        $newArrayClass = [];
        if ($records->class_id != null) {
            $makeClass = explode(',', $records->class_id);
            foreach ($makeClass as $item) {
                $classNew = ClassLevel::find($item);
                array_push($newArrayClass, $classNew->class);
            }
        }
        $newArrayTime = [];
        if ($records->time_tutor_id != null) {
            $makeTimetutor = explode(',', $records->time_tutor_id);
            foreach ($makeTimetutor as $item) {
                $timeNew = TimeSlot::find($item);
                array_push($newArrayTime, $timeNew->name);
            }
        }
        $newSchool = "";
        $newSalary = "";
        $newDistrict = "";
        if ($records->school_id != null) {
            $school = Schools::find($records->school_id);
            $newSchool = $school->name;
        }
        if ($records->salary_id != null) {
            $salary = RankSalary::find($records->salary_id);
            $newSalary = $salary->name;
        }
//        if ($records->DistrictID != null) {
//            $district = District::find($records->DistrictID);
//            $newDistrict = $district->name;
//        }

        if (!$records->Certificate) {
            $records->Certificate = [];
        }else{
            $records->Certificate= json_decode($records->Certificate);
        }
        $data = [
            'id'=> $id,
            'role' => $records->role,
            'gender' => $records->gender,
            'date_of_birth' => $records->date_of_birth,
            'name' => $records->name,
            'email' => $records->email,
            'avatar' => 'http://127.0.0.1:8000/storage/' . $records->avatar,
            'phone' => $records->phone,
            'address' => $records->address,
            'school' => $newSchool,
            'Citizen_card' => $records->Citizen_card,
            'education_level' => $newArrayEduaction,
            'class_id' => $newArrayClass,
            'subject' => $newArraySubject,
            'salary_id' => $newSalary,
            'description' => $records->description,
            'time_tutor_id' => $newArrayTime,
            'status' => $records->status,
            'DistrictID'=>$records->District_ID,
            'longitude'=>$records->longitude,
            'latitude'=>$records->latitude,
            'Certificate' => $records->Certificate,
            'current_role' => $records->current_role,
            'exp' => $records->exp

        ];
//        return $data;
            $title = "show Detail Teacher";
            return view('backend.subject.show',compact('title','data'));
    }
    public function add(SubjectRequest $request){
        $title = 'Thêm mới môn học';
        if($request->post()){
            $params = $request->post();
            $subject = new Subject();
            $subject->name = $request->name;
            $subject->save();
            if($subject->save()) {
                Session::flash('success', 'Thêm thành công!');
                return redirect()->route('search_subject');
            }
            else {
                Session::flash('error', 'Thêm không thành công!');
            }
        }
        return view('backend.subject.add', compact('title'));
    }
    public function edit(SubjectRequest $request, $id){
        $title = 'Sửa môn học';
        $subject = Subject::find($id);
        if($request->isMethod('post')){
            $update = Subject::where('id', $id)->update($request->except('_token'));
            if($update){
                Session::flash('success', 'Sửa thành công');
                return redirect()->route('search_subject');
            }else{
                Session::flash('error', 'Edit subject error');
            }
        }
            return view('backend.subject.edit', compact('title','subject'));
        }
        public function delete($id){
            if($id){
                $subject = Subject::find($id);
                $deleted = $subject->delete();
                if($deleted){
                    Session::flash('success','Xóa thành công!');
                    return redirect()->route('search_subject');
                }else{
                    Session::flash('error','xoa that bai');
                }
            }
        }
}
