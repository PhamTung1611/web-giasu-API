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
use Illuminate\Support\Facades\Validator;

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
    }

    public function getDetailTeacher($id){
        
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
        if($user){
            return response()->json($user,200);
        }else{
            return false;
        }
    }

    public function update(UserRequest $request,String $id)
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
        }catch (ModelNotFoundException $e) {
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
}
