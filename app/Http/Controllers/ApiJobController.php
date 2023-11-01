<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobResource;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tests = DB::table('jobs')->get();
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
            $test->subject = $subjectNames;
            $test->class = $classNames;
            $results[] = $test;
        }

        // Chuyển đổi mảng thành JSON
        $result = json_encode($results, JSON_UNESCAPED_UNICODE);
        return $result;
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
        $idUser = $request->input('idUser');
        $idTeacher = $request->input('idTeacher');
        $subject = json_encode($request->input('subject')); // Chuyển đổi thành JSON
        $class = json_encode($request->input('class')); // Chuyển đổi thành JSON
        try {
            DB::table('jobs')->insert([
                'idUser' => $idUser,
                'idTeacher' => $idTeacher,
                'subject' => $subject,
                'class' => $class,
            ]);

            // Trả về kết quả thành công
            return response()->json(['message' => 'Data inserted successfully'], 200);
        } catch (\Exception $e) {
            // Trả về thông báo lỗi nếu có lỗi xảy ra
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
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
        $test = Job::select('jobs.*', 'user1.name as idUser', 'user2.name as idTeacher')
        ->leftJoin('users as user1', 'jobs.idUser', '=', 'user1.id')
        ->leftJoin('users as user2', 'jobs.idTeacher', '=', 'user2.id')
        ->where('jobs.id', $id) // Thêm tên bảng trước trường 'id'
        ->first();

    if (!$test) {
        return response()->json(['message' => 'Jobs not found'], 404);
    }

    $dataSubject = json_decode($test->subject, true);

    $subjectNames = [];
    foreach ($dataSubject as $subjectId) {
        $subject = DB::table('subjects')->where('id', $subjectId)->value('name');
        if ($subject) {
            $subjectNames[] = $subject;
        }
    }
    $test->subject = $subjectNames;

    // Thêm trường 'class_name' từ ID 'class' trong kết quả
    $dataClass = json_decode($test->class, true); // Sửa đoạn này
    $classNames = [];
    foreach ($dataClass as $classId) {
        $class = DB::table('class_levels')->where('id', $classId)->value('class');
        if ($class) {
            $classNames[] = $class;
        }
    }
    $test->class = $classNames;

    $result = json_encode($test, JSON_UNESCAPED_UNICODE);
    return $result;
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
