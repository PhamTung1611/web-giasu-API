<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubjectController extends Controller
{
    public function index(Request $request){
        $title = 'List';
        $subject = Subject::all();
        return view('backend.subject.index', compact('subject', 'title'));
    }
    public function add(SubjectRequest $request){
        $title = 'Thêm mới môn học';
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
        return view('backend.subject.add', compact('title'));
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
            return view('backend.subject.edit', compact('title','subject'));
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
