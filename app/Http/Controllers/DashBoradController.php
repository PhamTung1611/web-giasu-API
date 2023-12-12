<?php

namespace App\Http\Controllers;

use App\Models\ClassLevel;
use App\Models\Connect;
use App\Models\FeedBack;
use App\Models\History;
use App\Models\Job;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashBoradController extends Controller
{
    //
    public function Statistical(Request $request)
    {
        $title = 'Thống kê';
        $money = History::where('id_client', '1')->orderBy('created_at', 'desc');

        $money->when($request->filled(['dateStart', 'dateEnd']), function ($query) use ($request) {
            $query->whereBetween('created_at', [$request->dateStart, $request->dateEnd]);
        });

        $history = $money->get();

        $totalCoins = 0;
        foreach ($history as $record) {
            $totalCoins += $record->coin; // Giả sử tên cột chứa số coin là 'coin'
        }

        // Count users based on role and status
        $countTeacher = $this->countUsersByRoleAndStatus('3', '1', $request);
        $countCollaborators = $this->countUsersByRoleAndStatus('4', '1', $request);
        $countTeacherWait = $this->countUsersByRoleAndStatus('3', '2', $request);
        $countUser = $this->countUsersByRole('2', $request);

        // Get top teachers based on feedback
        $results = DB::table('feedback')
            ->select('users.id', 'users.name', 'users.avatar', DB::raw('AVG(feedback.point) AS avg_point'))
            ->join('users', 'feedback.id_teacher', '=', 'users.id')
            ->groupBy('users.id', 'users.name', 'users.avatar')
            ->orderBy('avg_point', 'desc')
            ->limit(4)
            ->when($request->filled(['dateStart', 'dateEnd']), function ($query) use ($request) {
                $query->whereBetween('feedback.created_at', [$request->dateStart, $request->dateEnd]);
            })
            ->get();

        // Get information about top teachers based on job count
        $topTeachersInfo = DB::table('jobs')
            ->select('users.id as user_id', 'users.name as user_name', 'users.avatar as user_avatar', 'users.email as user_email', DB::raw('COUNT(jobs.id_teacher) as teacher_count'))
            ->join('users', 'jobs.id_teacher', '=', 'users.id')
            ->where('jobs.status', 1)
            ->groupBy('users.id', 'users.name', 'users.avatar', 'users.email')
            ->orderByDesc('teacher_count')
            ->limit(4)
            ->when($request->filled(['dateStart', 'dateEnd']), function ($query) use ($request) {
                $query->whereBetween('jobs.created_at', [$request->dateStart, $request->dateEnd]);
            })
            ->get();

        // Get most hired subjects
        $mostHiredSubjects = Subject::select('subjects.id', 'subjects.name', DB::raw('COALESCE(COUNT(jobs.id), 0) as hire_count'))
            ->leftJoin('jobs', function ($join) use ($request) {
                $join->on('jobs.subject', 'like', DB::raw("CONCAT('%,', subjects.id, ',%')"))
                    ->orWhere('jobs.subject', 'like', DB::raw("CONCAT(subjects.id, ',%')"))
                    ->orWhere('jobs.subject', 'like', DB::raw("CONCAT('%,', subjects.id)"))
                    ->orWhere('jobs.subject', 'like', DB::raw("CONCAT(subjects.id)"))
                    ->orWhereRaw("jobs.subject = CAST(subjects.id AS CHAR)");
                if ($request->filled(['dateStart', 'dateEnd'])) {
                    $join->whereBetween('jobs.created_at', [$request->dateStart, $request->dateEnd]);
                }
            })
            ->groupBy('subjects.id', 'subjects.name')
            ->orderByDesc('hire_count')
            ->get();

        // Get most hired subjects
        $mostHiredSubjects = Subject::select('subjects.id', 'subjects.name', DB::raw('COALESCE(COUNT(jobs.id), 0) as hire_count'))
            ->leftJoin('jobs', function ($join) use ($request) {
                $join->on('jobs.subject', 'like', DB::raw("CONCAT('%,', subjects.id, ',%')"))
                    ->orWhere('jobs.subject', 'like', DB::raw("CONCAT(subjects.id, ',%')"))
                    ->orWhere('jobs.subject', 'like', DB::raw("CONCAT('%,', subjects.id)"))
                    ->orWhere('jobs.subject', 'like', DB::raw("CONCAT(subjects.id)"))
                    ->orWhereRaw("jobs.subject = CAST(subjects.id AS CHAR)");
            })
            ->when($request->filled(['dateStart', 'dateEnd']), function ($query) use ($request) {
                $query->whereBetween('jobs.created_at', [$request->dateStart, $request->dateEnd]);
            })
            ->groupBy('subjects.id', 'subjects.name')
            ->orderByDesc('hire_count')
            ->get();

        // Get most hired class levels
        $mostHiredClass = ClassLevel::select('class_levels.id', 'class_levels.class', DB::raw('COALESCE(COUNT(jobs.id), 0) as hire_count'))
            ->leftJoin('jobs', function ($join) use ($request) {
                $join->on('jobs.class', 'like', DB::raw("CONCAT('%,',class_levels.id, ',%')"))
                    ->orWhere('jobs.class', 'like', DB::raw("CONCAT(class_levels.id, ',%')"))
                    ->orWhere('jobs.class', 'like', DB::raw("CONCAT('%,', class_levels.id)"))
                    ->orWhere('jobs.class', 'like', DB::raw("CONCAT(class_levels.id)"))
                    ->orWhereRaw("jobs.class = CAST(class_levels.id AS CHAR)");
            })
            ->when($request->filled(['dateStart', 'dateEnd']), function ($query) use ($request) {
                $query->whereBetween('jobs.created_at', [$request->dateStart, $request->dateEnd]);
            })
            ->groupBy('class_levels.id', 'class_levels.class')
            ->orderByDesc('hire_count')
            ->get();

        // Count connections based on status
        $countConnect = Connect::where('status', 1);
        if ($request->filled(['dateStart', 'dateEnd'])) {
            $countConnect->whereBetween('created_at', [$request->dateStart, $request->dateEnd]);
        }
        $countConnect = $countConnect->count();

        // Count total records in the connections table
        $totalRecords = Connect::count();

        // Get status counts and percentages
        $statusCounts = DB::table('connect')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->when($request->filled(['dateStart', 'dateEnd']), function ($query) use ($request) {
                $query->whereBetween('created_at', [$request->dateStart, $request->dateEnd]);
            })
            ->groupBy('status')
            ->get();

        $statusData = [];
        foreach ($statusCounts as $statusCount) {
            $statusName = $this->getStatusName($statusCount->status);
            $percentage = ($statusCount->count / $totalRecords) * 100;

            $statusData[] = [
                'status' => $statusName,
                'count' => $statusCount->count,
                'percentage' => $percentage,
            ];
        }

        return view('dashboard', compact('totalCoins', 'countTeacher', 'title', 'countTeacherWait', 'countUser', 'results', 'topTeachersInfo', 'mostHiredSubjects', 'countCollaborators', 'countConnect', 'mostHiredClass', 'statusData'));
    }

    private function countUsersByRole($role, Request $request)
    {
        $query = DB::table('users')->where('role', $role);

        if ($request->filled(['dateStart', 'dateEnd'])) {
            $query->whereBetween('created_at', [$request->dateStart, $request->dateEnd]);
        }

        return $query->count();
    }

    private function countUsersByRoleAndStatus($role, $status, Request $request)
    {
        $query = DB::table('users')->where('role', $role)->where('status', $status);

        if ($request->filled(['dateStart', 'dateEnd'])) {
            $query->whereBetween('created_at', [$request->dateStart, $request->dateEnd]);
        }

        return $query->count();
    }




    function getStatusName($status)
    {
        switch ($status) {
            case 0:
                return 'Chờ xác nhận';
            case 1:
                return 'Thành công';
            case 2:
                return 'Thất bại';
            default:
                return 'Không xác định';
        }
    }
    public function listHistoryAdmin(Request $request)
    {
        $title = 'Biến động doanh thu';
        $query = History::where('id_client', '1')->orderBy('created_at', 'desc');

        $query->when($request->filled(['dateStart', 'dateEnd']), function ($query) use ($request) {
            $query->whereBetween('created_at', [$request->dateStart, $request->dateEnd]);
        });

        $history = $query->get();

        $totalCoins = 0;
        foreach ($history as $record) {
            $totalCoins += $record->coin; // Giả sử tên cột chứa số coin là 'coin'
        }
        return view('backend.listHIstory.listforadmin', compact('history', 'title', 'totalCoins'));
    }

    public function feedbackTeacher(Request $request)
    {
        $title = 'FeedBack Gia Sư';
        $query = DB::table('feedback')
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
            );

        $query->when($request->filled(['dateStart', 'dateEnd']), function ($query) use ($request) {
            $query->whereBetween('feedback.created_at', [$request->dateStart, $request->dateEnd])
                ->whereNull('feedback.deleted_at');
        });

        $feedbacks = $query->get();

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
    public function rent(Request $request)
    {
        $title = 'Những gia sư được thuê';
        $query = DB::table('jobs')
            ->select('users.id as user_id', 'users.name as user_name', 'users.avatar as user_avatar', 'users.email as user_email', DB::raw('COUNT(jobs.id_teacher) as teacher_count'))
            ->join('users', 'jobs.id_teacher', '=', 'users.id')
            ->where('jobs.status', 1)
            ->groupBy('users.id', 'users.name', 'users.avatar', 'users.email')
            ->orderByDesc('teacher_count');

        $query->when($request->filled(['dateStart', 'dateEnd']), function ($query) use ($request) {
            // Điều kiện lọc theo khoảng thời gian
            $query->whereBetween('jobs.created_at', [$request->dateStart, $request->dateEnd]);
        });

        $topTeachersInfo = $query->get();

        return view('backend.listHIstory.rentTeacher', compact('title', 'topTeachersInfo'));
    }

    public function rentID()
    {

        $title = 'Những gia sư được thuê';
        $topTeachersInfo = DB::table('jobs')
            ->select('users.id as user_id', 'users.name as user_name', 'users.avatar as user_avatar', 'users.email as user_email', DB::raw('COUNT(jobs.id_teacher) as teacher_count'))
            ->join('users', 'jobs.id_teacher', '=', 'users.id')
            ->where('jobs.status', 1)
            ->groupBy('users.id', 'users.name', 'users.avatar', 'users.email')
            ->orderBy('teacher_count') // Sắp xếp theo thứ tự tăng dần
            ->get();
        return view('backend.listHIstory.rentTeacher', compact('title', 'topTeachersInfo'));
    }

    public function getStatusPercentage()
    {
        // Lấy tổng số lượng bản ghi
        $totalRecords = DB::table('connect')->count();

        // Lấy số lượng bản ghi cho mỗi trạng thái
        $statusCounts = DB::table('connect')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Tạo mảng để lưu trữ phần trăm cho mỗi trạng thái
        $statusPercentages = [];

        // Tính toán phần trăm và lưu vào mảng
        foreach ($statusCounts as $statusCount) {
            $percentage = ($statusCount->count / $totalRecords) * 100;
            $statusPercentages[$statusCount->status] = $percentage;
        }

        // Kết quả là mảng $statusPercentages, nơi bạn có phần trăm cho mỗi trạng thái
        return $statusPercentages;
    }
    public function listHistorySubject(Request $request)
    {
        $title = 'Thống kê lượt thuê môn học';
        $mostHiredSubjects = Subject::select('subjects.id', 'subjects.name', DB::raw('COALESCE(COUNT(jobs.id), 0) as hire_count'))
            ->leftJoin('jobs', function ($join) {
                $join->on('jobs.subject', 'like', DB::raw("CONCAT('%,', subjects.id, ',%')"))
                    ->orWhere('jobs.subject', 'like', DB::raw("CONCAT(subjects.id, ',%')"))
                    ->orWhere('jobs.subject', 'like', DB::raw("CONCAT('%,', subjects.id)"))
                    ->orWhere('jobs.subject', 'like', DB::raw("CONCAT(subjects.id)"))
                    ->orWhereRaw("jobs.subject = CAST(subjects.id AS CHAR)");
            })
            ->groupBy('subjects.id', 'subjects.name')
            ->orderByDesc('hire_count');

        $mostHiredSubjects->when($request->filled(['dateStart', 'dateEnd']), function ($query) use ($request) {
            $query->whereHas('jobs', function ($subQuery) use ($request) {
                $subQuery->whereBetween('created_at', [$request->dateStart, $request->dateEnd]);
            });
        });

        $mostHiredSubjects = $mostHiredSubjects->get();

        return view('backend.listHIstory.listSubject', compact('title', 'mostHiredSubjects'));
    }

    public function listHistoryClass(Request $request)
    {
        $title = 'Thống kê lượt thuê lớp học';
        $query = ClassLevel::select('class_levels.id', 'class_levels.class', DB::raw('COALESCE(COUNT(jobs.id), 0) as hire_count'))
            ->leftJoin('jobs', function ($join) {
                $join->on('jobs.class', 'like', DB::raw("CONCAT('%,',class_levels.id, ',%')"))
                    ->orWhere('jobs.class', 'like', DB::raw("CONCAT(class_levels.id, ',%')"))
                    ->orWhere('jobs.class', 'like', DB::raw("CONCAT('%,', class_levels.id)"))
                    ->orWhere('jobs.class', 'like', DB::raw("CONCAT(class_levels.id)"))
                    ->orWhereRaw("jobs.class = CAST(class_levels.id AS CHAR)");
            })
            ->groupBy('class_levels.id', 'class_levels.class')
            ->orderByDesc('hire_count');

        $query->when($request->filled(['dateStart', 'dateEnd']), function ($query) use ($request) {
            $query->whereHas('jobs', function ($subQuery) use ($request) {
                $subQuery->whereBetween('created_at', [$request->dateStart, $request->dateEnd]);
            });
        });

        $mostHiredClass = $query->get();

        return view('backend.listHIstory.listClass', compact('title', 'mostHiredClass'));
    }

    public function listHistoryConnect(Request $request)
    {
        $title = 'Thống kê lượt thuê lớp học';

        $query = DB::table('connect')->orderBy('created_at', 'desc');

        // Thêm điều kiện tìm kiếm theo ngày tháng
        $query->when($request->filled(['dateStart', 'dateEnd']), function ($query) use ($request) {
            $query->whereBetween('created_at', [$request->dateStart, $request->dateEnd]);
        });

        $totalRecords = $query->count();

        // Lấy số lượng bản ghi cho mỗi trạng thái
        $statusCounts = $query
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Tạo mảng để lưu trữ thông tin cho mỗi trạng thái
        $statusData = [];

        // Tính toán phần trăm và lưu vào mảng
        foreach ($statusCounts as $statusCount) {
            $statusName = $this->getStatusName($statusCount->status); // Hàm này để lấy tên trạng thái dựa trên giá trị status

            $percentage = ($statusCount->count / $totalRecords) * 100;

            // Lưu thông tin cho mỗi trạng thái
            $statusData[] = [
                'status' => $statusName,
                'count' => $statusCount->count,
                'percentage' => $percentage,
            ];
        }

        return view('backend.listHIstory.listConnect', compact('title', 'statusData'));
    }
}
