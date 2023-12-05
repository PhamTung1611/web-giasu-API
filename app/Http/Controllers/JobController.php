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
        $tests = Job::orderBy('id', 'desc')->get();
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

            $idUser = DB::table('users')->where('id', $test->id_user)->value('name');
            $idTeacher = DB::table('users')->where('id', $test->id_teacher)->value('name');

            $test->id_user = $idUser;
            $test->id_teacher = $idTeacher;
            $test->subject = implode(', ', $subjectNames); // Chuyển mảng thành chuỗi bằng hàm implode
            $test->class = implode(', ', $classNames); // Chuyển mảng thành chuỗi bằng hàm implode
            $results[] = $test;
        }
        // dd($results);
        return view('backend.job.index', compact('results','title'));
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
