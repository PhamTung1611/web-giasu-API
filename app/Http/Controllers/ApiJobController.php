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
    public function store(Request $request, MailController $mailController, HistoryController $historyController)
    {
        $idUser = $request->input('idUser');
        $idTeacher = $request->input('idTeacher');
        $emailUser = $this->findEmailById($idUser);
        $emailTeacher = $this->findEmailById($idTeacher);
        $user = User::find($idUser);
        if ($user) {
            $transfer = $historyController->transferMoney($idUser, 50000);
            if (!$transfer) {
                return response()->json(['message' => 'Not enough coin'], 404);
            } else {
                Job::create($request->all());
                $title = 'Đặt cọc thuê gia sư';
                $createHistory = $historyController->createHistory($idUser, -50000, $title);
                if ($createHistory) {
                    $titleForUser = 'Bạn đã thuê thành công gia sư.';
                    $titleForTeacher = 'Bạn có người muốn thuê hãy truy cập vào ngay trang web để biết thông tin chi tiết';
                    $sendUser = $mailController->sendMail($emailUser, $titleForUser);
                    $sendTeacher = $mailController->sendMail($emailTeacher, $titleForTeacher);
                    if ($sendUser && $sendTeacher) {
                        return response()->json(['message' => 'Success'], 200);
                    } else {
                        return response()->json(['message' => 'Error'], 404);
                    }
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
        $jobs = Job::select('jobs.*', 'user1.id as idUser', 'user1.name as userName', 'user2.id as idTeacher', 'user2.name as teacherName')
            ->leftJoin('users as user1', 'jobs.idUser', '=', 'user1.id')
            ->leftJoin('users as user2', 'jobs.idTeacher', '=', 'user2.id')
            ->where(function ($query) use ($id) {
                $query->where('jobs.idUser', $id)
                    ->orWhere('jobs.idTeacher', $id);
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
    
            // Lấy thông tin từ bảng users
            $user = DB::table('users')->where('id', $job->idUser)->first();
            $teacher = DB::table('users')->where('id', $job->idTeacher)->first();
    
            // Thêm id cho idUser và idTeacher
            $job->idUser = $user->id;
            $job->idTeacher = $teacher->id;
    
            // Thêm tên cho idUser và idTeacher
            $job->userName = $user->name;
            $job->teacherName = $teacher->name;
    
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
        $idUser = $job->idUser;
        $idTeacher = $job->idTeacher;
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
            $user = User::find($job->idUser);
            $teacher = User::find($job->idTeacher);
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
