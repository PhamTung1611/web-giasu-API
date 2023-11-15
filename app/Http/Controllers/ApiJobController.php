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
            $dataSubject = json_decode($item->subject, true);
            $subjectNames = [];
            foreach ($dataSubject as $subjectId) {
                $subject = DB::table('subjects')->where('id', $subjectId)->value('name');
                if ($subject) {
                    $subjectNames[] = $subject;
                }
            }
            $item->subject = $subjectNames;

            $dataClass = json_decode($item->class, true);
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
    public function update(Request $request, $id)
    {
        $job = Job::find($id);
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
                return response()->json(['message' => 'Success'], 200);
            } else {
                return response()->json(['message' => 'Error'], 404);
            }
        } else {
            if ($job) {
                $job->update($request->all());
                return response()->json(['message' => 'Success'], 200);
            } else {
                return response()->json(['message' => 'Error'], 404);
            }
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
