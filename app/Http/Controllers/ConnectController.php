<?php

namespace App\Http\Controllers;

use App\Models\Connect;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ConnectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Kết nối ';
        $connect = Connect::select(
            'connect.*',
            'user1.id as id_user',
            'user1.name as userName',
            'user2.id as id_teacher',
            'user2.name as teacherName'
        )
            ->leftJoin('users as user1', 'connect.id_user', '=', 'user1.id')
            ->leftJoin('users as user2', 'connect.id_teacher', '=', 'user2.id')
            ->get();

        if ($connect->isEmpty()) {
            return response()->json(['message' => 'Connect not found'], 404);
        }

        foreach ($connect as $item) {
            $item->id_job = $item->id_job;
            $item->id_user = $item->id_user;
            $item->id_teacher = $item->id_teacher;
            $item->userName = $item->userName;
            $item->teacherName = $item->teacherName;
        }
        // dd($connect);
        return view('backend.connect.index', compact('connect', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $connect = Connect::select(
                'connect.*',
                'user1.id as id_user',
                'user1.name as userName',
                'user1.avatar as userAvatar', // Thêm cột avatar cho user
                'user2.id as id_teacher',
                'user2.name as teacherName',
                'user2.avatar as teacherAvatar' // Thêm cột avatar cho teacher
            )
            ->leftJoin('users as user1', 'connect.id_user', '=', 'user1.id')
            ->leftJoin('users as user2', 'connect.id_teacher', '=', 'user2.id')
            ->where(function ($query) use ($id) {
                $query->where('connect.id_user', $id)
                    ->orWhere('connect.id_teacher', $id);
            })
            ->get();
    
        if ($connect->isEmpty()) {
            return response()->json(['message' => 'Connect not found'], 404);
        }
    
        foreach ($connect as $item) {
            // Có thể xử lý các thông tin khác ở đây nếu cần
    
            $item->id_user = $item->id_user;
            $item->id_teacher = $item->id_teacher;
            $item->userName = $item->userName;
            $item->teacherName = $item->teacherName;
        }
    
        return response()->json($connect, 200);
    }
    


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, MailController $mailController, HistoryController $historyController)
    {
        //
        // dd(1);
        // dd($request->all());
        $connect = Connect::find($id);
        // dd($connect);
        $noteUser = $request->input('note_user');
        $noteTeacher = $request->input('note_teacher');
        $confirmUser = $request->input('confirm_user');
        $confirmTeacher = $request->input('confirm_teacher');
        // dd($confirmTeacher,$confirmUser);
        $emailUser = $this->findEmailById($connect->id_user);
        $emailTeacher = $this->findEmailById($connect->id_teacher);
        if ($connect) {
            if ($confirmTeacher == 1) {
                $connect->update($request->all());
                $checkPoint = $connect->confirm_user;
                // dd($checkPoint ,);
                if ($checkPoint == $confirmTeacher) {
                    $connect->status = 1;
                    $connect->save();
                    $nameTeacher = $this->findNameByID($connect->id_teacher);
                    $nameUser = $this->findNameByID($connect->id_user);
                    $user = User::find($connect->id_user);
                    $teacher = User::find($connect->id_teacher);
                    // dd($user ,$teacher);
                    if ($user && $teacher) {
                        $refundMoney = $historyController->refundMoneyUserTeacher($connect->id_user, $connect->id_teacher, 25000);
                        if (!$refundMoney) {
                            return response()->json(['message' => 'Admin not enough coin'], 404);
                        } else {
                            $titleForUser = 'Gia sư ' . $nameTeacher . ' đã xác nhận kết nối với bạn. Bạn được hoàn lại 50% tiền cọc';
                            $titleForTeacher = 'Người dùng ' . $nameUser . ' đã xác nhận kết nối với bạn. Bạn được hoàn lại 50% tiền cọc';
                            $mailController->sendMail($emailUser, $titleForUser);
                            $mailController->sendMail($emailTeacher, $titleForTeacher);
                            return response()->json(['message' => 'Success'], 200);
                        }
                    } else {
                        return response()->json(['message' => 'Error'], 404);
                    }
                } else if ($checkPoint !== $confirmUser) {
                    $connect->update($request->all());
                    return response()->json(['message' => 'Success'], 200);
                }
            } else if ($confirmUser == 1) {
                $connect->update($request->all());
                $checkPoint = $connect->confirm_teacher;
                if ($checkPoint == $confirmUser) {
                    $connect->status = 1;
                    $connect->save();
                    $nameTeacher = $this->findNameByID($connect->id_teacher);
                    $nameUser = $this->findNameByID($connect->id_user);
                    $user = User::find($connect->id_user);
                    $teacher = User::find($connect->id_teacher);
                    if ($user && $teacher) {
                        $refundMoney = $historyController->refundMoneyUserTeacher($connect->id_user, $connect->id_teacher, 25000);
                        if (!$refundMoney) {
                            return response()->json(['message' => 'Admin not enough coin'], 404);
                        } else {
                            $titleForUser = 'Gia sư ' . $nameTeacher . ' đã xác nhận kết nối với bạn. Bạn được hoàn lại 50% tiền cọc';
                            $titleForTeacher = 'Người dùng ' . $nameUser . ' đã xác nhận kết nối với bạn. Bạn được hoàn lại 50% tiền cọc';
                            // $mailController->sendMail($emailUser, $titleForUser);
                            // $mailController->sendMail($emailTeacher, $titleForTeacher);
                            return response()->json(['message' => 'Success'], 200);
                        }
                    } else {
                        return response()->json(['message' => 'Error'], 404);
                    }
                } else if ($checkPoint !== $confirmUser) {
                    $connect->update($request->all());
                    return response()->json(['message' => 'Success'], 200);
                }
            } else if ($confirmTeacher == 2) {
                $connect->update($request->all());
                $checkPoint = $connect->confirm_user;
                if ($checkPoint !== $confirmUser) {
                    $connect->status = 2;
                    $connect->save();
                    $nameTeacher = $this->findNameByID($connect->id_teacher);
                    $nameUser = $this->findNameByID($connect->id_user);
                    $user = User::find($connect->id_user);
                    $teacher = User::find($connect->id_teacher);
                    if ($user && $teacher) {
                        $refundMoney = $historyController->refundMoneyUserTeacher($connect->id_user, $connect->id_teacher, 40000);
                        if (!$refundMoney) {
                            return response()->json(['message' => 'Admin not enough coin'], 404);
                        } else {
                            $titleForUser = 'Gia sư ' . $nameTeacher . ' đã hủy kết nối với lí do' . $noteTeacher . ' Bạn được hoàn lại 80% tiền cọc';
                            $titleForTeacher = 'Bạn đã ấn hủy kết nối với ' . $nameUser . ' với lí do' . $noteTeacher . ' Bạn được hoàn lại 80% tiền cọc';
                            // $mailController->sendMail($emailUser, $titleForUser);
                            // $mailController->sendMail($emailTeacher, $titleForTeacher);
                            return response()->json(['message' => 'Success'], 200);
                        }
                    } else {
                        return response()->json(['message' => 'Error'], 404);
                    }
                } else if ($checkPoint == $confirmTeacher) {
                    $connect->update($request->all());
                    return response()->json(['message' => 'Success'], 200);
                }
            } else if ($confirmUser == 2) {
                $connect->update($request->all());
                $checkPoint = $connect->confirm_teacher;
                if ($checkPoint !== $confirmUser) {
                    $connect->status = 2;
                    $connect->save();
                    $nameTeacher = $this->findNameByID($connect->id_teacher);
                    $nameUser = $this->findNameByID($connect->id_user);
                    $user = User::find($connect->id_user);
                    $teacher = User::find($connect->id_teacher);
                    if ($user && $teacher) {
                        $refundMoney = $historyController->refundMoneyUserTeacher($connect->id_user, $connect->id_teacher, 40000);
                        if (!$refundMoney) {
                            return response()->json(['message' => 'Admin not enough coin'], 404);
                        } else {
                            $titleForTeacher = 'Người dùng ' . $nameUser . ' đã hủy kết nối với lí do' . $noteUser . ' Bạn được hoàn lại 80% tiền cọc';
                            $titleForUser = 'Bạn đã ấn hủy kết nối với ' . $nameTeacher . ' với lí do' . $noteUser . ' Bạn được hoàn lại 80% tiền cọc';
                            // $mailController->sendMail($emailUser, $titleForUser);
                            // $mailController->sendMail($emailTeacher, $titleForTeacher);
                            return response()->json(['message' => 'Success'], 200);
                        }
                    } else {
                        return response()->json(['message' => 'Error'], 404);
                    }
                } else if ($checkPoint == $confirmUser) {
                    $connect->update($request->all());
                    return response()->json(['message' => 'Success'], 200);
                }
            } else {
                return response()->json(['message' => 'Error request'], 404);
            }
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function delete($id)
    {
        if ($id) {
            $class_levels = Connect::find($id);
            $deleted = $class_levels->delete();
            if ($deleted) {
                Session::flash('success', 'Xóa thành công');
                return redirect()->route('search_connect');
            } else {
                Session::flash('error', 'xoa that bai');
            }
        }
    }
    public function createConnect($idJob, $idUser, $idTeacher)
    {
        $connect = new Connect();
        $connect->id_job = $idJob;
        $connect->id_user = $idUser;
        $connect->id_teacher = $idTeacher;
        $connect->save();
        return true;
    }
    public function connectStatus($id)
    {
        $title = 'Kết nối';
        $connect = Connect::select(
            'connect.*',
            'user1.id as id_user',
            'user1.name as userName',
            'user2.id as id_teacher',
            'user2.name as teacherName'
        )
            ->where('connect.status', $id)
            ->leftJoin('users as user1', 'connect.id_user', '=', 'user1.id')
            ->leftJoin('users as user2', 'connect.id_teacher', '=', 'user2.id')
            ->get();

        foreach ($connect as $item) {
            $item->id_job = $item->id_job;
            $item->id_user = $item->id_user;
            $item->id_teacher = $item->id_teacher;
            $item->userName = $item->userName;
            $item->teacherName = $item->teacherName;
        }
        // dd($connect);
        return view('backend.connect.index', compact('connect', 'title'));
    }

    public function showConnect($id)
    {
        $title = 'Chi tiết kết nối';
        $connect = Connect::select(
            'connect.*',
            'user1.id as id_user',
            'user1.name as userName',
            'user2.id as id_teacher',
            'user2.name as teacherName',
            'class_levels.class as className',
            'subjects.name as subjectName'
        )
            ->leftJoin('users as user1', 'connect.id_user', '=', 'user1.id')
            ->leftJoin('users as user2', 'connect.id_teacher', '=', 'user2.id')
            ->leftJoin('jobs', 'connect.id_job', '=', 'jobs.id')
            ->leftJoin('class_levels', 'jobs.class', '=', 'class_levels.id') // Thêm join với bảng 'class'
            ->leftJoin('subjects', 'jobs.subject', '=', 'subjects.id') // Thêm join với bảng 'subject'
            ->where('connect.id', $id)
            ->get();

        foreach ($connect as $item) {
            // Truy cập thông tin từ các bảng 'class' và 'subject'
            $item->className = $item->className;
            $item->subjectName = $item->subjectName;
            $item->id_user = $item->id_user;
            $item->id_teacher = $item->id_teacher;
            $item->userName = $item->userName;
            $item->teacherName = $item->teacherName;
        }
        // dd($connect);
        return view('backend.connect.show', compact('connect', 'title'));
    }
}
