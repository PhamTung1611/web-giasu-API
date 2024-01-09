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

    public function index(Request $request)
    { 
        $title = 'Quản lí email';
    
        $typeMapping = [
            1 => 'Mail thuê gia sư',
            2 => 'Mail nhận yêu cầu thuê',
            3 => 'Mail đồng ý dạy',
            4 => 'Mail từ chối dạy',
            5 => 'Mail xác nhận kết nối',
            6 => 'Mail từ chối kết nối',
            7 => 'Mail đăng ký',
            8 => 'Mail đổi mật khẩu',
            9 => 'Mail phê duyệt gia sư',
            10 => 'Mail phê duyệt chứng chỉ',
            11 => 'Mail từ chối gia sư',
            12 => 'Mail từ chối chứng chỉ',
        ];
    
        $result = DB::table('history_send_mail')
            ->leftJoin('users', 'history_send_mail.id_user', '=', 'users.id')
            ->select('history_send_mail.*', 'users.name')
            ->orderBy('history_send_mail.created_at', 'desc');
    
        $result->when($request->filled(['dateStart', 'dateEnd']), function ($result) use ($request) {
            $result->whereBetween('history_send_mail.created_at', [$request->dateStart, $request->dateEnd]);
        });
    
        $data = $result->orderBy('history_send_mail.created_at', 'desc')->get();
    
        // Chuyển đổi giá trị của trường 'type' sang văn bản
        foreach ($data as $item) {
            $item->type = $typeMapping[$item->type] ?? $item->type;
        }
    
        return view('backend.sendEmail.index', compact('data', 'title'));
    }
    

    public function queryMail($id)
{
    $title = 'Quản lí email';

    $typeMapping = [
        1 => 'Mail thuê gia sư',
        2 => 'Mail nhận yêu cầu thuê',
        3 => 'Mail đồng ý dạy',
        4 => 'Mail từ chối dạy',
        5 => 'Mail xác nhận kết nối',
        6 => 'Mail từ chối kết nối',
        7 => 'Mail đăng ký',
        8 => 'Mail đổi mật khẩu',
        9 => 'Mail phê duyệt gia sư',
        10 => 'Mail phê duyệt chứng chỉ',
        11 => 'Mail từ chối gia sư',
        12 => 'Mail từ chối chứng chỉ',
    ];

    $data = DB::table('history_send_mail')
        ->leftJoin('users', 'history_send_mail.id_user', '=', 'users.id')
        ->select('history_send_mail.*', 'users.name')
        ->where('type', $id)
        ->orderBy('history_send_mail.created_at', 'desc')
        ->get();

    // Chuyển đổi giá trị của trường 'type' sang văn bản
    foreach ($data as $item) {
        $item->type = $typeMapping[$item->type] ?? $item->type;
    }

    return view('backend.sendEmail.index', compact('data', 'title'));
}

}
