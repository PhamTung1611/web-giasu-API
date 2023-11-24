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
        //
        $history = History::where('idClient', $id)->get();
        if ($history) {
            return response()->json($history, 200);
        } else {
            return response()->json(['message' => 'Not Found'], 404);
        }
    }

    public function createHistory($idClient, $coin, $type)
    {
        $history = new History();
        $history->idClient = $idClient;
        $history->coin = $coin;
        $history->type = $type;
        $history->save();
        return true;
    }

    // public function transferMoney($sender, $receiver, $coin)
    // {
    //     $sender = User::find($sender);
    //     $receiver = User::find($receiver);
    //     if ($sender && $receiver) {
    //         $balanceOfSender = floatval($sender->coin);
    //         $balanceOfReceiver = floatval($sender->coin);
    //         $sender->coin = strval($balanceOfSender - $coin);
    //         $receiver->coin = strval($balanceOfReceiver + $coin);
    //         $titleSender = 'Đặt cọc thuê gia sư';
    //         $titleReceiver = 'Nhận cọc thuê gia sư';
    //         $this->createHistory($sender, -50000, $titleSender);
    //         $this->createHistory($sender, +50000, $titleReceiver);
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
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
