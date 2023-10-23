<?php

namespace App\Http\Controllers;

use App\Models\FeedBack;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        //
        $data = FeedBack::create($request->all());
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
        //
        $data = FeedBack::select('feedback.*', 'users.name as idSender')
            // where('idTeacher',$id)
            ->leftJoin('users', 'feedback.idSender', '=', 'users.id')
            ->where('feedback.idTeacher', $id)
            ->get();
        if ($data) {
            return response()->json($data, 200);
        } else {
            return response()->json(['message' => 'Not Found'], 404);
        }
    }

    public function averagePoint(string $id)
    {
        $data = FeedBack::select('feedback.*', 'users.name as idSender')
            // where('idTeacher',$id)
            ->leftJoin('users', 'feedback.idSender', '=', 'users.id')
            ->where('feedback.idTeacher', $id)
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

        // Trả về kết quả dưới dạng JSON
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
}
