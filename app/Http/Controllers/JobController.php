<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Job;
use App\Models\RankSalary;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JobController extends Controller
{
    public function index() {
        $title = 'Jobs';
        $jobs = Job::all();
        return view('backend.job.index', compact('title', 'jobs'));
    }
    public function create(JobRequest $request) {
        $title = 'Add new job';
        $salary = RankSalary::all();
        $date = TimeSlot::all();
        if($request->post()) {
            $params = $request->post();
            unset($params['_token']);
            $job = new Job();
            $job->title = $request->title;
            $job->name = $request->name;
            $job->address = $request->address;
            $job->date_time = $request->date_time;
            $job->phone = $request->phone;
            $job->email = $request->email;
            $job->subjects_need = $request->subjects_need;
            $job->education_level = $request->education_level;
            $job->salary = $request->salary;
            $job->requirements = $request->requirements;
            $job->save();
            if($job->save()){
                Session::flash('success', 'Add new job success');
                return redirect()->to('job');
            }
            else {
                Session::flash('error', 'Error!');
            }
        }
        return view('backend.job.add', compact('title', 'salary', 'date'));
    }
    public function update(JobRequest $request, $id){
        $title = 'Sửa';
        $salary = RankSalary::all();
        $date = TimeSlot::all();
        $job = Job::findOrFail($id);
        if($request->isMethod('post')){
            $update = Job::where('id', $id)->update($request->except('_token'));
            if($update){
                Session::flash('success', 'Edit job success');
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
                Session::flash('success','Xoa thanh cong');
                return redirect()->route('search_job');
            }else{
                Session::flash('error','xoa that bai');
            }
        }
    }
}
