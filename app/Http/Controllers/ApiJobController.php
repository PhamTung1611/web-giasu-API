<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Models\User;
use Brick\Math\BigNumber;
use Faker\Core\Number;
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
    public function store(Request $request, MailController $mailController)
    {
        $job=new Job();
        $job->idUser = $request->idUser;
        $job->idTeacher = $request->idTeacher;
        $job->subject = implode(',',$request->subject);
        // dd( $job->subject);
        $job->class = implode(',',$request->class);
         $job->save();
        // $job = Job::create($request->all());
        // $job = Job::create($request->all());
        $idUser = $request->input('idUser');
        $idTeacher = $request->input('idTeacher');
        $emailUser = $this->findEmailById($idUser);
        $emailTeacher = $this->findEmailById($idTeacher);
        if ($job) {
            $titleForUser = 'Bạn đã thuê thành công gia sư.';
            $titleForTeacher = 'Bạn có người muốn thuê hãy truy cập vào ngay trang web để biết thông tin chi tiết';
            $sendUser = $mailController->sendMail($emailUser, $titleForUser);
            $sendTeacher = $mailController->sendMail($emailTeacher, $titleForTeacher);
            if ($sendUser && $sendTeacher) {
                return response()->json(['message' => 'Success'], 200);
            } else {
                return response()->json(['message' => 'Error'], 404);
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
        $test = Job::select('jobs.*', 'user1.name as idUser', 'user2.name as idTeacher')
            ->leftJoin('users as user1', 'jobs.idUser', '=', 'user1.id')
            ->leftJoin('users as user2', 'jobs.idTeacher', '=', 'user2.id')
            ->where(function ($query) use ($id) {
                $query->where('jobs.idUser', $id)
                    ->orWhere('jobs.idTeacher', $id);
            })
            ->get();

        if ($test->isEmpty()) {
            return response()->json(['message' => 'Jobs not found'], 404);
        }

        $result = [];
        foreach ($test as $item) {
            // dd($item->subject);
            $dataSubject = explode(',',$item->subject);
            $subjectNames = [];
            
            foreach ($dataSubject as $subjectId) {
                $subject = DB::table('subjects')->where('id', $subjectId)->value('name');
                if ($subject) {
                    $subjectNames[] = $subject;
                }
            }
            $item->subject = $subjectNames;

            $dataClass = explode(',',$item->class);
            $classNames = [];
            foreach ($dataClass as $classId) {
                $class = DB::table('class_levels')->where('id', $classId)->value('class');
                if ($class) {
                    $classNames[] = $class;
                }
            }
            $item->class = $classNames;

            $result[] = $item;
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
    public function update(Request $request, $id, MailController $mailController)
    {
        $job = Job::find($id);
        $idUser = $job->idUser;
        $idTeacher = $job->idTeacher;
        $status = $request->input('status');
        $description = $request->input('description');
        $emailUser = $this->findEmailById($idUser);
        $emailTeacher = $this->findEmailById($idTeacher);
        $checkStatus = $request->input('status');
        if ($checkStatus == 1) {
            if ($job) {
                $userId = $job->idTeacher;
                $user = User::find($userId);
                $balanceOfUser = floatval($user->coin);
                if ($user) {
                    if ($user->salary_id == 1) {
                        $user->coin = strval($balanceOfUser - 10000);
                        if (floatval($user->coin) < 0) {
                            return response()->json(['message' => 'Not enough coin'], 404);
                        }
                        $user->save();
                    } else if ($user->salary_id == 2) {
                        $user->coin = strval($balanceOfUser - 30000);
                        if (floatval($user->coin) < 0) {
                            return response()->json(['message' => 'Not enough coin'], 404);
                        }
                        $user->save();
                    } else if ($user->salary_id == 3) {
                        $user->coin = strval($balanceOfUser - 50000);
                        if (floatval($user->coin) < 0) {
                            return response()->json(['message' => 'Not enough coin'], 404);
                        }
                        $user->save();
                    } else if ($user->salary_id == 4) {
                        $user->coin = strval($balanceOfUser - 70000);
                        if (floatval($user->coin) < 0) {
                            return response()->json(['message' => 'Not enough coin'], 404);
                        }
                        $user->save();
                    }
                }
                $job->update($request->all());
                if ($status == 1) {
                    $nameTeacher = $this->findNameByID($idTeacher);
                    $titleForUser = 'Gia sư '.$nameTeacher.' đã đồng ý dạy. Vui lòng truy cập vào website để lấy thông tin liên lạc';
                    $titleForTeacher = 'Bạn vừa xác nhận một lịch dạy';
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
        } else {
            if ($job) {
                $job->update($request->all());
                if ($status == 2) {
                    $nameTeacher = $this->findNameByID($idTeacher);
                    $titleForUser = 'Gia sư'.$nameTeacher.' vừa từ chối lịch dạy của bạn với lí do '.$description;
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
                return response()->json(['message' => 'Success'], 200);
            } else {
                return response()->json(['message' => 'Error'], 404);
            }
        }
    }

    public function findNameByID($id){
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
}
