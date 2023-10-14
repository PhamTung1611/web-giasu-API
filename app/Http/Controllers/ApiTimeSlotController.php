<?php

namespace App\Http\Controllers;

use App\Http\Resources\TimeSlotResource;
use App\Models\TimeSlot;
use Illuminate\Http\Request;

class ApiTimeSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $time_slot = TimeSlot::all();
        return TimeSlotResource::collection($time_slot);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $time_slot = TimeSlot::create($request->all());
        return new TimeSlotResource($time_slot);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $time_slot = TimeSlot::find($id);
        if($time_slot){
            return new TimeSlotResource($time_slot);
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
        $time_slot = TimeSlot::find($id);
        if($time_slot){
            $time_slot->update($request->all());
            return new TimeSlotResource($time_slot);
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
        $time_slot = TimeSlot::find($id);
        if($time_slot){
            $time_slot->delete();
            return response()->json(['message'=>'Xóa thành công'], 200);
        }else{
            return response()->json(['message'=>'Lỗi hệ thống'], 404);
        }
    }
}
