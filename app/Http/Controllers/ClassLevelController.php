<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassLevelRequest;
use App\Models\ClassLevel;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ClassLevelController extends Controller
{
    public function index(Request $request){
        $title = "Danh sách lớp học";
        
        $class_levels = ClassLevel::all();
        if ($request->post() && $request->search) {
            $class_levels = DB::table('class_levels')
                ->where('class', 'like', '%'.$request->search.'%')->get();
        }
        return view('backend.class.index', compact('class_levels', 'title'));
    }
    public function ListTeacher($id){
        $title = 'Giáo viên dạy';
        $class = ClassLevel::find($id);
        if (!$class) {
            abort(404);
        }
        $teachers = User::where('class_id', $id)->where('role','3')->where('status','1')->get();
        // dd($teachers);
        return view('backend.subject.teacher',compact('title', 'class', 'teachers'));
    }
    public function add(ClassLevelRequest $request){
        $title = 'Thêm mới lớp học';
        // $subject = Subject::all();
        if($request->post()){
            $params = $request->post();
            $class_levels = new ClassLevel();
            $class_levels->class = $request->class;
            $class_levels->save();
            if($class_levels->save()) {
                Session::flash('success', 'Thêm thành công!');
                return redirect()->route('search_class');
            }
            else {
                Session::flash('error', 'Thêm không thành công!');
            }
        }
        return view('backend.class.add', compact('title'));
    }
    public function edit(ClassLevelRequest $request, $id){
        $title = 'Sửa lớp học';
        // $subjects = Subject::all();
        $class_levels = ClassLevel::findOrFail($id);
        if($request->isMethod('post')){
            $update = ClassLevel::where('id', $id)->update($request->except('_token'));
            if($update){
                Session::flash('success', 'Sửa thành công!');
                return redirect()->route('search_class');
            }else{
                Session::flash('error', 'Edit class error');
            }
        }
            return view('backend.class.edit', compact('title','class_levels'));
        }
    public function delete($id){
        if($id){
            $class_levels = ClassLevel::find($id);
            $deleted = $class_levels->delete();
            if($deleted){
                Session::flash('success','Xóa thành công');
                return redirect()->route('search_class');
            }else{
                Session::flash('error','xoa that bai');
            }
        }
    }
}
