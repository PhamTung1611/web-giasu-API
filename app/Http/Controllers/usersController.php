<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Exception;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use phpseclib3\File\ASN1\Maps\UserNotice;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function signin(Request $request) {
        if($request->isMethod('POST')) {
            // dd($request);
            // try {
                // dd(123);
                if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])) {
                    // dd(123);
                    //  return view('dashboard');
                    return redirect()->route('dashboard');
                }
                else{
                    // dd(432);
                    Session::flash('error', 'Sai thông tin đăng nhập');
                    return redirect()->route('login');
                }
            // } catch (\Throwable $th) {
            //     dd($th);
            // }
        }
        
        return view('auth.login');
    }
    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
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
            $userData = $request->all();
            $user = User::create($userData);
            if ($user) {
                return response()->json($user, 201);
            } else {
                return response()->json(['error' => 'Thêm không thành công'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
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
            $params = $request->post();
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
            $update = User::where('id', $id)->update($request->except('_token'));
            if($update){
                Session::flash('success', 'Edit user success');
                return redirect()->route('search_user');
            }else{
                Session::flash('error', 'Edit subject error');
            }
        }
        return view('backend.users.edit', compact('title','user'));

    }
}
