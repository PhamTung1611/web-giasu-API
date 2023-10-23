<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Exception;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use phpseclib3\File\ASN1\Maps\UserNotice;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::where('role', 'user')->get();
            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }

        // $users = User::select('users.*', 'district.name as district_name', 'class_levels.class as class_name')
        //     ->leftJoin('district', 'users.districtID', '=', 'district.id')
        //     ->leftJoin('class_levels', 'users.class', '=', 'class_levels.id')
        //     ->where('users.role', 'user')
        //     ->get();

        // return  response()->json($users, 200);
    }
    public function store(UserRequest $request)
    {
        try {
            $user = new User;
            $role = Role::find($request->role);
//            dd($role->name);
            if(!$role){
                return response()->json('Sai quyền',400);
            }
            $user->role= $role->name;
            $user->gender = $request->gender;
            $user->date_of_birth = $request->date_of_birth;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->avatar= $request->avatar;

            $user->password= Hash::make($request->password);
            $user->address = $request->address;
            $user->DistrictID = $request->districtID;
            $user->phone = $request->phone;
            if($request->role == 3 ){
                $user->school_id = $request->school_id;
                $user->Citizen_card = $request->citizen_card;
                $user->education_level = $request->education_level;
                $user->class_id = $request->class_id;
                $subject = implode(",",$request->subject);
                $user->subject =$subject;
                $user->salary_id = $request->salary_id;
                $user->description = $request->description;
                $user->time_tutor_id = $request->time_tutor_id;
                $user->status = 1 ;
                $user->time_tutor_id = $request->time_tutor_id;
                $user->Certificate= $request->Certificate;
            }

            $user->save();

            return response()->json("success", 201);
        } catch (\Exception $e) {
            return response()->json(['error' => "Thêm không thành công,$e"], 400);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('role', 'user')->find($id);
        if ($user) {
            return response()->json($user, 200);
        } else {
            return false;
        }
    }

    public function update(UserRequest $request, String $id)
    {
        try {
            $user = User::findOrFail($id);
            $data = $request->all();
            $update = $user->update($data);
            if ($update) {
                return response()->json($user, 200);
            } else {
                return response()->json(['error' => 'Update không thành công'], 400);
            }
        } catch (ModelNotFoundException $e) {
            // Xử lý ngoại lệ nếu không tìm thấy user
            return response()->json(['error' => 'User not found'], 404);
        } catch (QueryException $e) {
            // Xử lý ngoại lệ nếu có lỗi trong truy vấn cơ sở dữ liệu
            return response()->json(['error' => $e], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        try {
            $user = User::findOrFail($id);
            $delete = $user->delete();
            if ($delete) {
                return response()->json(null, 204);
            } else {
                return response()->json("Xóa không thành công", 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }
    public function getAllUser()
    {
        $title = 'List';
        $users = User::where('role', 'user')->get();
        return view('backend.users.index', compact('users', 'title'));
    }
    public function addNewUser(UserRequest $request){
        $title = 'Thêm mới user';
        if($request->isMethod('post')){
            // dd($request);
            // $params = $request->post();
            $params = $request->except('_token');
            if($request->hasFile('avatar') && $request->file('avatar')->isValid()){
                $params['avatar'] = uploadFile('hinh',$request->file('avatar'));
            }
            // dd($params);
            // unset($params['_token']);
            $user = new User();
            $user->role=$request->role;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->avatar = $request->avatar;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->fill($params);
            $user->save();
            if($user->save()) {
                Session::flash('success', 'Thêm thành công!');
                return redirect()->route('search_user');
            }
            else {
                Session::flash('error', 'Thêm không thành công!');
            }
        }
        return view('backend.users.add', compact('title'));
    }
    public function updateUser(UserRequest $request, $id){
        $title = 'Sửa User';
        $user = User::findOrFail($id);
        if($request->isMethod('post')){
            $params = $request->except('_token');
            if($request->hasFile('avatar') && $request->file('avatar')->isValid()){
                $deleteImage = Storage::delete('/public/'.$user->avatar);
                if($deleteImage){
                    $params['avatar'] = uploadFile('hinh',$request->file('avatar'));
                }

            }
            // $update = User::where('id', $id)->update($request->except('_token'));
            $update = User::where('id', $id)->update($params);
            if($update){
                Session::flash('success', 'Edit user success');
                return redirect()->route('search_user');
            }else{
                Session::flash('error', 'Edit subject error');
            }
        }
        return view('backend.users.edit', compact('title','user'));

    }
    public function delete($id){
        if($id){
            $user = User::find($id);
            $deleted = $user->delete();
            if($deleted){
                Session::flash('success','Xoa thanh cong');
                return redirect()->route('search_user');
            }else{
                Session::flash('error','xoa that bai');
            }
        }
    }
}
