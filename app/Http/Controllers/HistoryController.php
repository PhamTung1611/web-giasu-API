<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;

class HistoryController extends Controller
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
        $history = History::where('id_client', $id)->get();
        if ($history) {
            return response()->json($history, 200);
        } else {
            return response()->json(['message' => 'Not Found'], 404);
        }
    }

    public function createHistory($idClient, $coin, $type)
    {
        $history = new History();
        $history->id_client = $idClient;
        $history->coin = $coin;
        $history->type = $type;
        $history->save();
        return true;
    }

    public function transferMoney($sender, $coin)
    {
        $sender = User::find($sender);
        $receiver = User::find(1);
        if ($sender && $receiver) {
            $balanceOfSender = floatval($sender->coin);
            $balanceOfReceiver = floatval($receiver->coin);
            $sender->coin = strval($balanceOfSender - $coin);
            $receiver->coin = strval($balanceOfReceiver + $coin);
            if (floatval($sender->coin) < 0) {
                return false;
            } else {
                $sender->save();
                $receiver->save();
                $titleSender = 'Đặt cọc thuê gia sư';
                $titleReceiver = 'Nhận cọc thuê gia sư';
                $this->createHistory($sender->id, -$coin, $titleSender);
                $this->createHistory($receiver->id, +$coin, $titleReceiver);
                return true;
            }
        } else {
            return false;
        }
    }
    public function refundMoney($receiver,$coin){
        $sender = User::find(1);
        $receiver = User::find($receiver);
        if ($sender && $receiver) {
            $balanceOfSender = floatval($sender->coin);
            $balanceOfReceiver = floatval($receiver->coin);
            $sender->coin = strval($balanceOfSender - $coin);
            $receiver->coin = strval($balanceOfReceiver + $coin);
            // dd($sender->coin);
            if (floatval($sender->coin) < 0) {
                return false;
            } else {
                $sender->save();
                $receiver->save();
                $title = 'Hoàn tiền cọc gia sư từ chối';
                $this->createHistory($sender->id, -$coin, $title);
                $this->createHistory($receiver->id, +$coin, $title);
                return true;
            }
        } else {
            return false;
        }
    }
    public function refundMoneyUserTeacher($userID,$teacherID,$coin){
            $user = User::find($userID);
            $teacher = User::find($teacherID);
            $admin = User::find(1);
            if ($user && $teacher) {
                $balanceOfSender = floatval($user->coin);
                $balanceOfReceiver = floatval($teacher->coin);
                $balanceOfAdmin = floatval($admin->coin);
                $user->coin = strval($balanceOfSender + $coin);
                $teacher->coin = strval($balanceOfReceiver + $coin);
                $admin->coin = strval($balanceOfAdmin - $coin - $coin);
                // dd($sender->coin);
                if (floatval($admin->coin) < 0) {
                    return false;
                } else {
                    $user->save();
                    $teacher->save();
                    $admin->save();
                    if(strval($coin) == 25000){
                        $title = 'Hoàn tiền 50% cọc kết nối được với nhau';
                        $this->createHistory($user->id, $coin, $title);
                        $this->createHistory($teacher->id, $coin, $title);
                        $this->createHistory($admin->id, - strval($coin *2 ), $title);
                    }else if(strval($coin) == 40000){
                        $title = 'Hoàn tiền 80% cọc không kết nối được với nhau';
                        $this->createHistory($user->id, $coin, $title);
                        $this->createHistory($teacher->id, $coin, $title);
                        $this->createHistory($admin->id, - strval($coin *2 ), $title);
                    }
                    return true;
                }
            }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
