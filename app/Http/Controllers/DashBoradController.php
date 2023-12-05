<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\User;
use Google\Service\Forms\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashBoradController extends Controller
{
    //
    public function Statistical()
    {
        $title = 'Thống kê';
        $countTeacher = DB::table('users')->where('role', 'teacher')->where('status', '1')->count();
        $countTeacherWait = DB::table('users')->where('role', 'teacher')->where('status', '2')->count();
        $countUser = DB::table('users')->where('role', 'user')->count();
        $user =  User::find(1);
        $money = $user->coin;
        $query = DB::table('feedback')
            ->select('users.id', 'users.name', 'users.avatar', DB::raw('AVG(feedback.point) AS avg_point'))
            ->join('users', 'feedback.id_teacher', '=', 'users.id')
            ->groupBy('users.id', 'users.name', 'users.avatar') // Group by the id, name, and image columns
            ->orderBy('avg_point', 'desc')
            ->limit(4);
        $results = $query->get();
        // dd($results);
        $topTeachersInfo = DB::table('jobs')
            ->select('users.id as user_id', 'users.name as user_name', 'users.avatar as user_avatar', DB::raw('COUNT(jobs.id_teacher) as teacher_count'))
            ->join('users', 'jobs.id_teacher', '=', 'users.id')
            ->where('jobs.status', 1)  // Chỉ rõ cột 'status' thuộc bảng 'jobs'
            ->groupBy('users.id', 'users.name', 'users.avatar')
            ->orderByDesc('teacher_count')
            ->limit(4)
            ->get();


        // dd($topTeachersInfo);
        return view('dashboard', compact('money', 'countTeacher', 'title', 'countTeacherWait', 'countUser', 'results', 'topTeachersInfo'));
    }

    public function listHistoryAdmin()
    {
        $title = 'Biến động doanh thu';
        $history = History::where('id_client', '1')->orderBy('created_at', 'desc')->get();
        // dd($history);
        return view('backend.listHIstory.listforadmin', compact('history', 'title'));
    }
    public function feedbackTeacher()
    {
        $title = 'FeedBack Gia Sư';
        $feedbacks = DB::table('feedback')
            ->join('users as sender', 'feedback.id_sender', '=', 'sender.id')
            ->join('users as teacher', 'feedback.id_teacher', '=', 'teacher.id')
            ->select(
                'feedback.id',
                'feedback.id_sender',
                'sender.name as sender_name',
                'feedback.id_teacher',
                'teacher.name as teacher_name',
                'feedback.point',
                'feedback.description'
            )
            ->get();
        // dd($feedbacks);
        return view('backend.listHIstory.topstarteacher', compact('title', 'feedbacks'));
    }

    public function starTeacher($id)
    {
        $title = 'FeedBack Gia Sư ' . $id . ' Sao';
        $feedbacks = DB::table('feedback')
            ->join('users as sender', 'feedback.id_sender', '=', 'sender.id')
            ->join('users as teacher', 'feedback.id_teacher', '=', 'teacher.id')
            ->select(
                'feedback.id',
                'feedback.id_sender',
                'sender.name as sender_name',
                'feedback.id_teacher',
                'teacher.name as teacher_name',
                'feedback.point',
                'feedback.description'
            )
            ->where('point', $id)->get();
        // dd($feedbacks);
        return view('backend.listHIstory.topstarteacher', compact('title', 'feedbacks'));
    }
}
