<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $tests = DB::table('jobs')->get();
    //     $results = [];

    //     foreach ($tests as $test) {
    //         $dataArray = json_decode($test->subject, true);

    //         $subjectNames = [];
    //         foreach ($dataArray as $id) {
    //             $subject = DB::table('subjects')->where('id', $id)->value('name');
    //             if ($subject) {
    //                 $subjectNames[] = $subject;
    //             }
    //         }

    //         $classNames = [];
    //         foreach ($dataArray as $id) {
    //             $class = DB::table('class_levels')->where('id', $id)->value('class');
    //             if ($class) {
    //                 $classNames[] = $class;
    //             }
    //         }

    //         $idUser = DB::table('users')->where('id', $test->idUser)->value('name');
    //         $idTeacher = DB::table('users')->where('id', $test->idTeacher)->value('name');

    //         $test->idUser = $idUser;
    //         $test->idTeacher = $idTeacher;
    //         $test->subject = $subjectNames;
    //         $test->class = $classNames;
    //         $results[] = $test;
    //     }

    //     // Chuyển đổi mảng thành JSON
    //     $result = json_encode($results, JSON_UNESCAPED_UNICODE);
    //     return $result;
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, MailController $mailController, HistoryController $historyController)
    {
        $idUser = $request->input('id_user');
        $idTeacher = $request->input('id_teacher');
        $emailUser = $this->findEmailById($idUser);
        $emailTeacher = $this->findEmailById($idTeacher);
        $user = User::find($idUser);
        if ($user) {
            $transfer = $historyController->transferMoney($idUser, 50000);
            if (!$transfer) {
                return response()->json(['message' => 'Not enough coin'], 404);
            } else {
                Job::create($request->all());
                $titleForUser = 'Bạn đã thuê gia sư thành công vui lòng đợi phản hồi của gia sư ';
                $titleForTeacher = 'Bạn đang có người muốn thuê ';
                $sendUser = $mailController->sendMail($emailUser, $titleForUser);
                $sendTeacher = $mailController->sendMail($emailTeacher, $titleForTeacher);
                if ($sendUser && $sendTeacher) {
                    return response()->json(['message' => 'Success'], 200);
                } else {
                    return response()->json(['message' => 'Error'], 404);
                }
            }
        } else {
            return response()->json(['message' => 'Error'], 404);
        }
    }

    public function findEmailById($id)
    {
        $user = User::find($id);
        if ($user) {
            $email = $user->email;
            return $email;
        } else {
            return false;
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
        $jobs = Job::select(
            'jobs.*',
            'user1.id as id_user',
            'user1.name as userName',
            DB::raw("CONCAT('http://127.0.0.1:8000/storage/', user1.avatar) as userAvatar"),
            'user2.id as id_teacher',
            'user2.name as teacherName',
            DB::raw("CONCAT('http://127.0.0.1:8000/storage/', user2.avatar) as teacherAvatar")
        )
        ->leftJoin('users as user1', 'jobs.id_user', '=', 'user1.id')
        ->leftJoin('users as user2', 'jobs.id_teacher', '=', 'user2.id')
        ->where(function ($query) use ($id) {
            $query->where('jobs.id_user', $id)
                ->orWhere('jobs.id_teacher', $id);
        })
        ->get();
    
        if ($jobs->isEmpty()) {
            return response()->json(['message' => 'Jobs not found'], 404);
        }
    
        $result = [];
        foreach ($jobs as $job) {
            $dataSubject = explode(',', $job->subject);
            $subjectNames = [];
    
            foreach ($dataSubject as $subjectId) {
                $subject = DB::table('subjects')->where('id', $subjectId)->value('name');
                if ($subject) {
                    $subjectNames[] = $subject;
                }
            }
            $job->subject = $subjectNames;
    
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
    
            $job->userAvatar = 'http://127.0.0.1:8000/storage/' . $user->avatar;
            $job->teacherAvatar = 'http://127.0.0.1:8000/storage/' . $teacher->avatar;
    
            $result[] = $job;
        }
    
        return response()->json($result, 200);
    }
    
    


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, MailController $mailController, HistoryController $historyController, ConnectController $connectController)
    {
        $job = Job::find($id);
        $idUser = $job->id_user;
        $idTeacher = $job->id_teacher;
        $status = $request->input('status');
        $description = $request->input('description');
        $emailUser = $this->findEmailById($idUser);
        $emailTeacher = $this->findEmailById($idTeacher);
        if ($job) {
            if ($status == 1) {
                $teacher = User::find($idTeacher);
                if ($teacher) {
                    $transfer = $historyController->transferMoney($idTeacher, 50000);
                    if (!$transfer) {
                        return response()->json(['message' => 'Not enough coin'], 404);
                    } else {
                        $job->update($request->all());
                        // dd($id, $idUser, $idTeacher);
                        $connectController->createConnect($id, $idUser, $idTeacher);
                        $nameTeacher = $this->findNameByID($idTeacher);
                        $titleForUser = 'Gia sư ' . $nameTeacher . ' đã đồng ý dạy. Vui lòng truy cập vào website để lấy thông tin liên lạc';
                        $titleForTeacher = 'Bạn vừa xác nhận một lịch dạy';
                        $sendUser = $mailController->sendMail($emailUser, $titleForUser);
                        $sendTeacher = $mailController->sendMail($emailTeacher, $titleForTeacher);
                        if ($sendUser && $sendTeacher) {
                            return response()->json(['message' => 'Success'], 200);
                        } else {
                            return response()->json(['message' => 'Error'], 404);
                        }
                    }
                }
            } else if ($status == 2) {
                $user = User::find($idUser);
                if ($user) {
                    $transfer = $historyController->refundMoney($idUser, 50000);
                    if (!$transfer) {
                        return response()->json(['message' => 'Admin Not enough coin'], 404);
                    } else {
                        $job->update($request->all());
                        $nameTeacher = $this->findNameByID($idTeacher);
                        $titleForUser = 'Gia sư' . $nameTeacher . ' vừa từ chối lịch dạy của bạn với lí do: ' . $description . ' .Tài khoản của bạn đã được hoàn tiền';
                        $titleForTeacher = 'Bạn vừa từ chối một lịch dạy';
                        $sendUser = $mailController->sendMail($emailUser, $titleForUser);
                        $sendTeacher = $mailController->sendMail($emailTeacher, $titleForTeacher);
                        // dd(123);
                        if ($sendUser && $sendTeacher) {
                            return response()->json(['message' => 'Success'], 200);
                        } else {
                            return response()->json(['message' => 'Error'], 404);
                        }
                    }
                }
            }
        } else {
            return response()->json(['message' => 'Error'], 404);
        }
    }

    public function findNameByID($id)
    {
        $user = User::find($id);
        if ($user) {
            $name = $user->name;
            return $name;
        } else {
            return false;
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
        if ($job) {
            $job->delete();
            return response()->json(['message' => 'Xóa thành công'], 200);
        } else {
            return response()->json(['message' => 'Lỗi hệ thống'], 404);
        }
    }

    public function showDetailJob($id)
    {
        $job = Job::find($id);
        if ($job && $job->status == 1) {
            $user = User::find($job->id_user);
            $teacher = User::find($job->id_teacher);
            return response()->json([
                'nameUser' => $user->name,
                'nameTeacher' => $teacher->name,
                'emailUser' => $user->email,
                'emailTeacher' => $teacher->email,
                'phoneUser' => $user->phone,
                'phoneTeacher' => $teacher->phone,
                'addressUser' => $user->address,
                'addressTeacher' => $teacher->address,
                'date_create' => $job->created_at
            ], 200);
        } else {
            return response()->json(['message' => 'Error'], 404);
        }
    }
}
