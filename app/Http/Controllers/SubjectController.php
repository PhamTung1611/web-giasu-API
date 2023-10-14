<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubjectController extends Controller
{
    public function dashboard(){
        $title = 'Dashboard';
        return view('dashboard', compact('title'));
    }
    public function index(Request $request){
        $subject = Subject::all();
        return view('subject.index', compact('subject'));
    }
    public function add(SubjectRequest $request){
        $title = 'Them moi mon hoc';
        if($request->post()){
            $params = $request->post();
            $subject = new Subject();
            $subject->name = $request->name;
            $subject->save();
            if($subject->save()) {
                Session::flash('success', 'Thêm thành công!');
                return redirect()->route('search_subject');
            }
            else {
                Session::flash('error', 'Thêm không thành công!');
            }
        }
        return view('subject.add', compact('title'));
    }
    public function edit(SubjectRequest $request, $id){
        $title = 'Sửa môn học';
        $subject = Subject::find($id);
        if($request->isMethod('post')){
            $update = Subject::where('id', $id)->update($request->except('_token'));
            if($update){
                Session::flash('success', 'Edit subject success');
                return redirect()->route('search_subject');
            }else{
                Session::flash('error', 'Edit subject error');
            }
        }
            return view('subject.edit', compact('title','subject'));
        }
        public function delete($id){
            if($id){
                $subject = Subject::find($id);
                $deleted = $subject->delete();
                if($deleted){
                    Session::flash('success','Xoa thanh cong');
                    return redirect()->route('search_subject');
                }else{
                    Session::flash('error','xoa that bai');
                }
            }
        }
}
