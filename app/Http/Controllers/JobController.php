<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Job;
use App\Models\RankSalary;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class JobController extends Controller
{
    public function index(Request $request) {
        $title = 'Danh sách công việc';
        $tests = DB::table('jobs')->get();
        if ($request->post() && $request->search) {
            $tests = DB::table('jobs')
                ->where('id', 'like', '%'.$request->search.'%')->get();
        }
        $results = [];

        foreach ($tests as $test) {
            $dataArray = json_decode($test->subject, true);

            $subjectNames = [];
            foreach ($dataArray as $id) {
                $subject = DB::table('subjects')->where('id', $id)->value('name');
                if ($subject) {
                    $subjectNames[] = $subject;
                }
            }
            
            $classNames = [];
            foreach ($dataArray as $id) {
                $class = DB::table('class_levels')->where('id', $id)->value('class');
                if ($class) {
                    $classNames[] = $class;
                }
            }

            $idUser = DB::table('users')->where('id', $test->idUser)->value('name');
            $idTeacher = DB::table('users')->where('id', $test->idTeacher)->value('name');

            $test->idUser = $idUser;
            $test->idTeacher = $idTeacher;
            $test->subject = implode(', ', $subjectNames); // Chuyển mảng thành chuỗi bằng hàm implode
            $test->class = implode(', ', $classNames); // Chuyển mảng thành chuỗi bằng hàm implode
            $results[] = $test;
        }
        return view('backend.job.index', compact('results','title'));
    }
    public function create(JobRequest $request) {
        $title = 'Thêm mới công việc';
        $salary = RankSalary::all();
        $date = TimeSlot::all();
        if($request->post()) {
            $params = $request->post();
            unset($params['_token']);
            $job = new Job();
            // $job->title = $request->title;
            // $job->name = $request->name;
            // $job->address = $request->address;
            $job->date_time = $request->date_time;
            // $job->phone = $request->phone;
            // $job->email = $request->email;
            $job->subjects_need = $request->subjects_need;
            $job->education_level = $request->education_level;
            $job->salary = $request->salary;
            $job->requirements = $request->requirements;
            $job->save();
            if($job->save()){
                Session::flash('success', 'Thêm thành công!');
                return redirect()->to('job');
            }
            else {
                Session::flash('error', 'Error!');
            }
        }
        return view('backend.job.add', compact('title', 'salary', 'date'));
    }
    public function update(JobRequest $request, $id){
        $title = 'Sửa công việc';
        $salary = RankSalary::all();
        $date = TimeSlot::all();
        $job = Job::findOrFail($id);
        if($request->isMethod('post')){
            $update = Job::where('id', $id)->update($request->except('_token'));
            if($update){
                Session::flash('success', 'Sửa thành công');
                return redirect()->route('search_job');
            }else{
                Session::flash('error', 'Edit job error');
            }
        }
            return view('backend.job.edit', compact('title','job', 'salary', 'date'));
    }
    public function delete($id){
        if($id){
            $job = Job::find($id);
            $deleted = $job->delete();
            if($deleted){
                Session::flash('success','Xoá thành công!');
                return redirect()->route('search_job');
            }else{
                Session::flash('error','xoa that bai');
            }
        }
    }
}
