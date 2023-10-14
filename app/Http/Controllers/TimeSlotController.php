<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSlotRequest;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TimeSlotController extends Controller
{
    public function index(){
        $title = 'List';
        $timeslots = TimeSlot::all();
        return view('backend.timeslot.index', compact('title', 'timeslots'));
    }
    public function create(TimeSlotRequest $request){
        $title = 'thêm mới';
            if($request->post()){
                $params = $request->post();
                $timeslot = new TimeSlot();
                $timeslot->value = $request->value;
                $timeslot->save();
                if($timeslot->save()) {
                    Session::flash('success', 'Thêm thành công!');
                    return redirect()->route('search_timeslot');
                }
                else {
                    Session::flash('error', 'Thêm không thành công!');
                }
            }
            return view('backend.timeslot.add', compact('title'));
    }
    public function update(TimeSlotRequest $request, $id){
        $title = 'Sửa';
        $timeslot = TimeSlot::findOrFail($id);
        if($request->isMethod('post')){
            $update = TimeSlot::where('id', $id)->update($request->except('_token'));
            if($update){
                Session::flash('success', 'Sửa thành công');
                return redirect()->route('search_timeslot');
            }else{
                Session::flash('error', 'Sửa không thành công!');
            }
        }
            return view('backend.timeslot.edit', compact('title','timeslot'));
    }
    public function delete($id){
        if($id){
            $timeslot = TimeSlot::find($id);
            $deleted = $timeslot->delete();
            if($deleted){
                Session::flash('success','Xoa thanh cong');
                return redirect()->route('search_timeslot');
            }else{
                Session::flash('error','xoa that bai');
            }
        }
    }
}
