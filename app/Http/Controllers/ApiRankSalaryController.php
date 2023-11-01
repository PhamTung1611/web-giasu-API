<?php

namespace App\Http\Controllers;

use App\Http\Resources\RankSalaryResource;
use App\Models\RankSalary;
use Illuminate\Http\Request;

class ApiRankSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rank_salary = RankSalary::all();
        return response()->json($rank_salary, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rank_salary = RankSalary::create($request->all());
        return new RankSalaryResource($rank_salary);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rank_salary = RankSalary::find($id);
        if($rank_salary){
            return new RankSalaryResource($rank_salary);
        }else{
            return response()->json(['message'=>'Lỗi hệ thống'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rank_salary = RankSalary::find($id);
        if($rank_salary){
            $rank_salary->update($request->all());
            return new RankSalaryResource($rank_salary);
        }else{
            return response()->json(['message'=>'Lỗi hệ thống'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rank_salary = RankSalary::find($id);
        if($rank_salary){
            $rank_salary->delete();
            return response()->json(['message'=>'Xóa thành công'], 200);
        }else{
            return response()->json(['message'=>'Lỗi hệ thống'], 404);
        }
    }
}
