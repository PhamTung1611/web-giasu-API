<?php

namespace App\Http\Controllers;

use App\Models\HistorySendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorySendMailController extends Controller
{
    //
    public function create($idUser, $email, $type, $content)
    {
        $history = new HistorySendMail();
        $history->id_user = $idUser;
        $history->email = $email;
        $history->type = $type;
        $history->content = $content;
        $history->save();
        return true;
    }

    public function index()
    { 
          $title = 'Quản lí email';
          $result = DB::table('history_send_mail')
          ->leftJoin('users', 'history_send_mail.id_user', '=', 'users.id')
          ->select('history_send_mail.*', 'users.name')
          ->orderBy('history_send_mail.created_at', 'desc')
          ->get();
        //   dd($result);
        return view ('backend.sendEmail.index',compact('result','title'));
    }
}
