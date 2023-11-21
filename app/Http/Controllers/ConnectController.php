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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, MailController $mailController)
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
            if ($confirmTeacher == 1 || $confirmUser == 1) {
                $connect->update($request->all());
                $checkPoint = $connect->confirmUser;
                if ($checkPoint == $confirmUser) {
                    $nameTeacher = $this->findNameByID($connect->idTeacher);
                    $nameUser = $this->findNameByID($connect->idUser);
                    $titleForUser = 'Gia sư ' . $nameTeacher . ' đã xác nhận dạy. Bạn được hoàn lại 50% tiền cọc';
                    $titleForTeacher = 'Người dùng ' . $nameUser . ' đã xác nhận bạn đi dạy. Bạn được hoàn lại 50% tiền cọc';
                    $mailController->sendMail($emailUser, $titleForUser);
                    $mailController->sendMail($emailTeacher, $titleForTeacher);
                    return response()->json(['message' => 'Success'], 200);
                }else{

                }
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
