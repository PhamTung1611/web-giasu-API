<?php

namespace App\Http\Controllers;

use App\Models\FeedBack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FeedBackController extends Controller
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
    public function store(Request $request,HistoryController $historyController)
    {
        //
        $data = FeedBack::create($request->all());
        if($data->point == 5){
            $historyController->addCoin($data->id_teacher);
        }
        if ($data) {
            return response()->json(['message' => 'Success'], 200);
        } else {
            return response()->json(['message' => 'Error'], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = FeedBack::select(
            'feedback.*',
            'users.name as id_sender',
            DB::raw("CONCAT('http://127.0.0.1:8000/storage/', users.avatar) as sender_avatar")
        )
        ->leftJoin('users', 'feedback.id_sender', '=', 'users.id')
        ->where('feedback.id_teacher', $id)
        ->get();
    
        if ($data->isEmpty()) {
            return response()->json(['message' => 'Not Found'], 404);
        }
    
        foreach ($data as $item) {
            // Có thể xử lý các thông tin khác ở đây nếu cần
    
            $item->id_sender = $item->id_sender;
            $item->sender_avatar = $item->sender_avatar;
        }
    
        return response()->json($data, 200);
    }

    public function showUser(string $id)
    {
        $data = FeedBack::select(
            'feedback.*',
            'users.name as id_teacher',
            DB::raw("CONCAT('http://127.0.0.1:8000/storage/', users.avatar) as sender_avatar")
        )
        ->leftJoin('users', 'feedback.id_teacher', '=', 'users.id')
        ->where('feedback.id_sender', $id)
        ->get();
    
        if ($data->isEmpty()) {
            return response()->json(['message' => 'Not Found'], 404);
        }
    
        foreach ($data as $item) {
            // Có thể xử lý các thông tin khác ở đây nếu cần
    
            $item->id_teacher = $item->id_teacher;
            $item->sender_avatar = $item->sender_avatar;
        }
    
        return response()->json($data, 200);
    }
    
    

    public function averagePoint(string $id)
    {
        $data = FeedBack::select('feedback.*', 'users.name as id_sender')
            ->leftJoin('users', 'feedback.id_sender', '=', 'users.id')
            ->where('feedback.id_teacher', $id)
            ->get();
        $dataArray = json_decode($data, true);
        $totalPoints = 0;

        // Đếm số lượng phần tử trong mảng
        $count = count($dataArray);

        // Duyệt qua mảng và tính tổng điểm
        foreach ($dataArray as $item) {
            $totalPoints += (int) $item['point'];
        }

        // Tính trung bình cộng
        if ($count > 0) {
            $averagePoint = $totalPoints / $count;
        } else {
            $averagePoint = 0;
        }
        return response()->json([
            'avg' => $averagePoint
        ]);
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
    public function getAllFeedback(Request $request){
        $title = 'List';
        $feedback = FeedBack::all();
        return view('backend.feedback.index', compact('feedback', 'title'));
    }
    public function delete($id){
        if($id){
            $feedback = FeedBack::find($id);
            $deleted = $feedback->delete();
            if($deleted){
                Session::flash('success','Xóa thành công');
                return redirect()->route('search_feedback');
            }else{
                Session::flash('error','Xóa thất bại');
            }
        }
    }
}
