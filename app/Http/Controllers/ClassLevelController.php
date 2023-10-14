<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassLevelRequest;
use App\Models\ClassLevel;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClassLevelController extends Controller
{
    public function index(Request $request){
        $class_levels = ClassLevel::all();
        return view('class.index', compact('class_levels'));
    }
    public function add(ClassLevelRequest $request){
        $title = 'Thêm mới lớp học';
        $subject = Subject::all();
        if($request->post()){
            $params = $request->post();
            $class_levels = new ClassLevel();
            $class_levels->class = $request->class;
            $class_levels->subject = $request->subject;
            $class_levels->save();
            if($class_levels->save()) {
                Session::flash('success', 'Thêm thành công!');
                return redirect()->route('search_class');
            }
            else {
                Session::flash('error', 'Thêm không thành công!');
            }
        }
        return view('class.add', compact('title','subject'));
    }
    public function edit(ClassLevelRequest $request, $id){
        $title = 'Sửa lop hoc';
        $subjects = Subject::all();
        $class_levels = ClassLevel::findOrFail($id);
        if($request->isMethod('post')){
            $update = ClassLevel::where('id', $id)->update($request->except('_token'));
            if($update){
                Session::flash('success', 'Edit class success');
                return redirect()->route('search_class');
            }else{
                Session::flash('error', 'Edit class error');
            }
        }
            return view('class.edit', compact('title','class_levels','subjects'));
        }
    public function delete($id){
        if($id){
            $class_levels = ClassLevel::find($id);
            $deleted = $class_levels->delete();
            if($deleted){
                Session::flash('success','Xoa thanh cong');
                return redirect()->route('search_class');
            }else{
                Session::flash('error','xoa that bai');
            }
        }
    }
}
