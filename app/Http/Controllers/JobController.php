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
    public function index(Request $request)
    {
        $title = 'Danh sách công việc';
        $jobs = DB::table('jobs')
            ->select(
                'jobs.id',
                'users_user.id as user_id',
                'users_user.name as user_name',
                'users_teacher.id as teacher_id',
                'users_teacher.name as teacher_name',
                'subjects.name as subject_name',
                'class_levels.class as class_name',
                'jobs.description',
                'jobs.status'
            )
            ->leftJoin('users as users_user', 'jobs.id_user', '=', 'users_user.id')
            ->leftJoin('users as users_teacher', 'jobs.id_teacher', '=', 'users_teacher.id')
            ->leftJoin('subjects', 'jobs.subject', '=', 'subjects.id')
            ->leftJoin('class_levels', 'jobs.class', '=', 'class_levels.id')
            ->orderBy('jobs.created_at', 'desc')
            ->get();

        foreach ($jobs as $job) {
            $job->user_id;
            $job->user_name;
            $job->teacher_id;
            $job->teacher_name;
            $job->subject_name;
            $job->class_name;
            $job->description;
            $job->status;
        }
        // dd($jobs);
        return view('backend.job.index', compact('jobs', 'title'));
    }

    public function update(JobRequest $request, $id)
    {
        $title = 'Sửa công việc';
        $salary = RankSalary::all();
        $date = TimeSlot::all();
        $job = Job::findOrFail($id);
        if ($request->isMethod('post')) {
            $update = Job::where('id', $id)->update($request->except('_token'));
            if ($update) {
                Session::flash('success', 'Sửa thành công');
                return redirect()->route('search_job');
            } else {
                Session::flash('error', 'Edit job error');
            }
        }
        return view('backend.job.edit', compact('title', 'job', 'salary', 'date'));
    }
    public function delete($id)
    {
        if ($id) {
            $job = Job::find($id);
            $deleted = $job->delete();
            if ($deleted) {
                Session::flash('success', 'Xoá thành công!');
                return redirect()->route('search_job');
            } else {
                Session::flash('error', 'xoa that bai');
            }
        }
    }
    public function getJobStatus($id){
        $title = 'Danh sách công việc';
        $jobs = DB::table('jobs')
            ->select(
                'jobs.id',
                'users_user.id as user_id',
                'users_user.name as user_name',
                'users_teacher.id as teacher_id',
                'users_teacher.name as teacher_name',
                'subjects.name as subject_name',
                'class_levels.class as class_name',
                'jobs.description',
                'jobs.status'
            )->where('jobs.status',$id)
            ->leftJoin('users as users_user', 'jobs.id_user', '=', 'users_user.id')
            ->leftJoin('users as users_teacher', 'jobs.id_teacher', '=', 'users_teacher.id')
            ->leftJoin('subjects', 'jobs.subject', '=', 'subjects.id')
            ->leftJoin('class_levels', 'jobs.class', '=', 'class_levels.id')
            ->orderBy('jobs.created_at', 'desc')
            ->get();

        foreach ($jobs as $job) {
            $job->user_id;
            $job->user_name;
            $job->teacher_id;
            $job->teacher_name;
            $job->subject_name;
            $job->class_name;
            $job->description;
            $job->status;
        }
        // dd($jobs);
        return view('backend.job.index', compact('jobs', 'title'));
    }
}
