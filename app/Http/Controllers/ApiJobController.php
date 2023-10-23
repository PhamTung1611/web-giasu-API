<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobResource;
use App\Models\Job;
use Illuminate\Http\Request;

class ApiJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::all();
        return JobResource::collection($jobs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $job = Job::create($request->all());
        $job = Job::create($request->all());
        if ($job) {
            return response()->json(['message' => 'Success'], 200);
        } else {
            return response()->json(['message' => 'Error'], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = Job::select('jobs.*', 'user1.name as idUser', 'user2.name as idTeacher', 'subjects.name as idSubject')
        ->leftJoin('users as user1', 'jobs.idUser', '=', 'user1.id')
        ->leftJoin('users as user2', 'jobs.idTeacher', '=', 'user2.id')
        ->leftJoin('subjects', 'jobs.idSubject', '=', 'subjects.id')
        ->where(function ($query) use ($id) {
            $query->where('jobs.idUser', $id)
                ->orWhere('jobs.idTeacher', $id);
        })
        ->get();
        if($job){
            return response()->json($job, 200);
        }else{
            return response()->json(['message'=>'Not Found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $job = Job::find($id);
        if ($job) {
            $job->update($request->all());
            return response()->json(['message' => 'Success'], 200);
        } else {
            return response()->json(['message' => 'Error'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Job::find($id);
        if($job){
            $job->delete();
            return response()->json(['message'=>'Xóa thành công'], 200);
        }else{
            return response()->json(['message'=>'Lỗi hệ thống'], 404);
        }
    }
}
