<?php

namespace App\Http\Controllers;

use App\Http\Requests\RankSalaryRequest;
use App\Models\RankSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RankSalaryController extends Controller
{
    public function index(){
        $title = 'List';
        $salaries = RankSalary::all();
        return view('backend.ranksalary.index', compact('title', 'salaries'));
    }
    public function create(RankSalaryRequest $request){
        $title = 'thêm mới';
            if($request->post()){
                $params = $request->post();
                $ranksalary = new RankSalary();
                $ranksalary->value = $request->value;
                $ranksalary->save();
                if($ranksalary->save()) {
                    Session::flash('success', 'Thêm thành công!');
                    return redirect()->route('search_salary');
                }
                else {
                    Session::flash('error', 'Thêm không thành công!');
                }
            }
            return view('backend.ranksalary.add', compact('title'));
    }
    public function update(RankSalaryRequest $request, $id){
        $title = 'Sửa';
        $salary = RankSalary::findOrFail($id);
        if($request->isMethod('post')){
            $update = RankSalary::where('id', $id)->update($request->except('_token'));
            if($update){
                Session::flash('success', 'Edit salary success');
                return redirect()->route('search_salary');
            }else{
                Session::flash('error', 'Edit salary error');
            }
        }
            return view('backend.ranksalary.edit', compact('title','salary'));
    }
    public function delete($id){
        if($id){
            $salary = RankSalary::find($id);
            $deleted = $salary->delete();
            if($deleted){
                Session::flash('success','Xoa thanh cong');
                return redirect()->route('search_salary');
            }else{
                Session::flash('error','xoa that bai');
            }
        }
    }
}
