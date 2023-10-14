<?php

namespace App\Http\Controllers;
use App\Models\Schools;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class schoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $schools = Schools::all();
            return response()->json($schools, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            $shoolData = $request->all();
            $school = Schools::create($shoolData);
            if ($school) {
                return response()->json($school, 201);
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
        try {
            $school = Schools::findOrFail($id);
            return response()->json($school, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => "User không tồn tại"], 404);
        }
    }


    public function update(Request $request, string $id)
    {

        try {
            $school = Schools::findOrFail($id);
            $data = $request->all();
            $update = $school->update($data);
            if ($update) {
                return response()->json($school, 200);
            } else {
                return response()->json(['error' => 'Update không thành công'], 400);
            }
        }catch (ModelNotFoundException $e) {
            // Xử lý ngoại lệ nếu không tìm thấy user
            return response()->json(['error' => 'School not found'], 404);
        } catch (QueryException $e) {
            // Xử lý ngoại lệ nếu có lỗi trong truy vấn cơ sở dữ liệu
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $school = Schools::findOrFail($id);
            $delete = $school->delete();
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
