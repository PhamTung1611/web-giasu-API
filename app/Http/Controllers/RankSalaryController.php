<?php

namespace App\Http\Controllers;

use App\Http\Requests\RankSalaryRequest;
use App\Models\RankSalary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RankSalaryController extends Controller
{
    public function index(Request $request){
        $title = 'Danh sách mức lương';
        $salaries = RankSalary::orderBy('id', 'desc')->get();
        // $salaries = RankSalary::all();
        if ($request->post() && $request->search) {
            $salaries = DB::table('rank_salaries')
                ->where('name', 'like', '%'.$request->search.'%')->get();
        }
        return view('backend.ranksalary.index', compact('title', 'salaries'));
    }
    public function ListTeacher($id){
        $title = 'Giáo viên dạy';
        $salary = RankSalary::find($id);
        if (!$salary) {
            abort(404);
        }
        $teachers = User::where('salary_id', $id)->where('role','3')->where('status','1')->get();
        // dd($teachers);
        return view('backend.ranksalary.teacher',compact('title', 'salary', 'teachers'));
    }
    public function add(RankSalaryRequest $request){
        $title = 'Thêm mới mức lương';
        if($request->post()){
            $params = $request->post();
            $ranksalary = new RankSalary();
            $ranksalary->name = $request->name;
            $ranksalary->save();
            if($ranksalary->save()) {
                Session::flash('success', 'Thêm thành công!');
                return redirect()->to('salary');
            }
            else {
                Session::flash('error', 'Thêm không thành công!');
            }
        }
        return view('backend.ranksalary.add', compact('title'));
    }
    public function update(RankSalaryRequest $request, $id){
        $title = 'Sửa mức lương';
        $salary = RankSalary::findOrFail($id);
        if($request->isMethod('post')){
            $update = RankSalary::where('id', $id)->update($request->except('_token'));
            if($update){
                Session::flash('success', 'Sửa thành công!');
                return redirect()->route('search_salary');
            }else{
                Session::flash('error', 'Sửa lỗi');
            }
        }
            return view('backend.ranksalary.edit', compact('title','salary'));
    }
    public function delete($id){
        if($id){
            $salary = RankSalary::find($id);
            $deleted = $salary->delete();
            if($deleted){
                Session::flash('success','Xóa thành công!');
                return redirect()->to('salary');
            }else{
                Session::flash('error','Xóa thất bại');
            }
        }
    }
}
