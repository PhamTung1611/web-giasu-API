<?php

namespace App\Http\Controllers;

use App\Models\Connect;
use App\Models\User;
use Illuminate\Http\Request;

class ConnectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
        $connect = Connect::select('connect.*', 'user1.name as idUser', 'user2.name as idTeacher')
            ->leftJoin('users as user1', 'connect.idUser', '=', 'user1.id')
            ->leftJoin('users as user2', 'connect.idTeacher', '=', 'user2.id')
            ->where(function ($query) use ($id) {
                $query->where('connect.idUser', $id)
                    ->orWhere('connect.idTeacher', $id);
            })
            ->get();

        if ($connect->isEmpty()) {
            return response()->json(['message' => 'Connect not found'], 404);
        }
        // dd($connect->idUser);
        return response()->json($connect, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, MailController $mailController, HistoryController $historyController)
    {
        //
        $connect = Connect::find($id);
        $noteUser = $request->input('noteUser');
        $noteTeacher = $request->input('noteTeacher');
        $confirmUser = $request->input('confirmUser');
        $confirmTeacher = $request->input('confirmTeacher');
        $emailUser = $this->findEmailById($connect->idUser);
        $emailTeacher = $this->findEmailById($connect->idTeacher);
        if ($connect) {
            if ($confirmTeacher == 1) {
                $connect->update($request->all());
                $checkPoint = $connect->confirmUser;
                // dd($checkPoint);
                if ($checkPoint == $confirmTeacher) {
                    $connect->status = 1;
                    $connect->save();
                    $nameTeacher = $this->findNameByID($connect->idTeacher);
                    $nameUser = $this->findNameByID($connect->idUser);
                    $user = User::find($connect->idUser);
                    $teacher = User::find($connect->idTeacher);
                    if ($user && $teacher) {
                        $refundMoney = $historyController->refundMoneyUserTeacher($connect->idUser, $connect->idTeacher, 25000);
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
                $checkPoint = $connect->confirmTeacher;
                if ($checkPoint == $confirmUser) {
                    $connect->status = 1;
                    $connect->save();
                    $nameTeacher = $this->findNameByID($connect->idTeacher);
                    $nameUser = $this->findNameByID($connect->idUser);
                    $user = User::find($connect->idUser);
                    $teacher = User::find($connect->idTeacher);
                    if ($user && $teacher) {
                        $refundMoney = $historyController->refundMoneyUserTeacher($connect->idUser, $connect->idTeacher, 25000);
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
                } else {
                    $connect->update($request->all());
                    return response()->json(['message' => 'Success'], 200);
                }
            } else if ($confirmTeacher == 2) {
                $connect->update($request->all());
                $connect->status = 2;
                $connect->save();
                $nameTeacher = $this->findNameByID($connect->idTeacher);
                $nameUser = $this->findNameByID($connect->idUser);
                $user = User::find($connect->idUser);
                $teacher = User::find($connect->idTeacher);
                if ($user && $teacher) {
                    $refundMoney = $historyController->refundMoneyUserTeacher($connect->idUser, $connect->idTeacher, 10000);
                    if (!$refundMoney) {
                        return response()->json(['message' => 'Admin not enough coin'], 404);
                    } else {
                        $titleForUser = 'Gia sư ' . $nameTeacher . ' đã hủy kết nối với lí do' . $noteTeacher . ' Bạn được hoàn lại 80% tiền cọc';
                        $titleForTeacher = 'Bạn đã ấn hủy kết nối với ' . $nameUser . ' với lí do' . $noteTeacher . ' Bạn được hoàn lại 80% tiền cọc';
                        $mailController->sendMail($emailUser, $titleForUser);
                        $mailController->sendMail($emailTeacher, $titleForTeacher);
                        return response()->json(['message' => 'Success'], 200);
                    }
                } else {
                    return response()->json(['message' => 'Error'], 404);
                }
            } else if ($confirmUser == 2) {
                $connect->update($request->all());
                $connect->status = 2;
                $connect->save();
                $nameTeacher = $this->findNameByID($connect->idTeacher);
                $nameUser = $this->findNameByID($connect->idUser);
                $user = User::find($connect->idUser);
                $teacher = User::find($connect->idTeacher);
                if ($user && $teacher) {
                    $refundMoney = $historyController->refundMoneyUserTeacher($connect->idUser, $connect->idTeacher, 10000);
                    if (!$refundMoney) {
                        return response()->json(['message' => 'Admin not enough coin'], 404);
                    } else {
                        $titleForTeacher = 'Người dùng ' . $nameUser . ' đã hủy kết nối với lí do' . $noteUser . ' Bạn được hoàn lại 80% tiền cọc';
                        $titleForUser = 'Bạn đã ấn hủy kết nối với ' . $nameTeacher . ' với lí do' . $noteUser . ' Bạn được hoàn lại 80% tiền cọc';
                        $mailController->sendMail($emailUser, $titleForUser);
                        $mailController->sendMail($emailTeacher, $titleForTeacher);
                        return response()->json(['message' => 'Success'], 200);
                    }
                } else {
                    return response()->json(['message' => 'Error'], 404);
                }
            } else {
                return response()->json(['message' => 'Error'], 404);
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

    public function createConnect($idJob, $idUser, $idTeacher)
    {
        $connect = new Connect();
        $connect->idJob = $idJob;
        $connect->idUser = $idUser;
        $connect->idTeacher = $idTeacher;
        $connect->save();
        return true;
    }
}
