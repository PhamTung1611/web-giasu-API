<?php

namespace App\Http\Controllers;

use App\Models\ClassLevel;
use App\Models\District;
use App\Models\RankSalary;
use App\Models\Role;
use App\Models\Schools;
use App\Models\Subject;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Exception;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use phpseclib3\File\ASN1\Maps\UserNotice;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function signin(Request $request)
    {
        if ($request->isMethod('POST')) {
            // dd($request);
            // try {
            // dd(123);
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // dd(123);
                //  return view('dashboard');
                return redirect()->route('dashboard');
            } else {
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
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function showvnpay()
    {
        return view('payment');
    }

    public function depositInsertDatabase(Request $request){
        $id= $request->input('id');
        $coin=$request->input('coin');

        $user = User::find($id);

        if($user){
            $user->coin += $coin;
            $user->save();

            return response()->json(['message'=>'Nạp tiền thành công'],200);
        }
        return response()->json(['message'=>'Nạp tiền lỗi'],400);
    }
    public function deposit(Request $request)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:3000/profile/history";
        $vnp_TmnCode = "YSRAA9QW"; //Mã website tại VNPAY
        $vnp_HashSecret = "BWGVWFDPSGGASGPKLZMCMYEOHKLKHNFF"; //Chuỗi bí mật
        $data = $request->all();
        $vnp_TxnRef = rand(1, 10000); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 1;
        $vnp_OrderType = "GS7";
        $vnp_Amount = $data['total'];
        $vnp_Locale = "VN";
        $vnp_BankCode = "";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        //Billing
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }
    public function index()
    {
        try {
            $users = User::where('role', 'user')->get();
            $users = $users->map(function ($user) {
                if ($user->avatar) {
                    $user->avatar = 'http://127.0.0.1:8000/storage/' . $user->avatar;
                }
                if ($user->Certificate) {
                    $user->Certificate = json_decode($user->Certificate);
                }
                return $user;
            });
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

            if (!$role) {
                return response()->json('Sai quyền', 400);
            }
            $user->role = $role->name;
            $user->gender = $request->gender;
            $user->date_of_birth = $request->date_of_birth;
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $user->avatar = uploadFile('hinh', $request->file('avatar'));
            } else {
                $user->avatar = "hinh/1699622845_avatar.jpg";
            }
            $user->password = Hash::make($request->password);
            $user->address = $request->address;
            $user->DistrictID = json_encode($request->DistrictID);
            $user->phone = $request->phone;
            if ($request->role == 3) {
                $user->exp = $request->exp;
                $user->current_role = $request->current_role;
                $user->school_id = $request->school_id;
                $user->Citizen_card = $request->citizen_card;
                $user->education_level = $request->education_level;
                $class = implode(",", $request->class_id);
                $user->class_id = $class;
                $subject = implode(",", $request->subject);
                $user->subject = $subject;
                $user->salary_id = $request->salary_id;
                if ($request->has('Certificate')) {
                    $certificates = [];
                    foreach ($request->file('Certificate') as $file) {
                            $certificates[] = 'http://127.0.0.1:8000/storage/' . uploadFile('hinh', $file);
                    }
                    $user->Certificate = json_encode($certificates); // Lưu đường dẫn của các ảnh trong một mảng JSON
                } else {
                    $user->Certificate = null;
                }
                $user->address = json_encode($request->address);
                $user->description = $request->description;
                $time_tutor = implode(",", $request->time_tutor_id);
                $user->time_tutor_id = $time_tutor;
                $user->status = 2;
            } else {
                $user->status = 1;
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
        $records = User::where('id', $id)
            ->first();

        $newArraySubject = [];
        if ($records->subject != null) {
            $makeSubject = explode(',', $records->subject);
            foreach ($makeSubject as $item) {
                $subjectNew = Subject::find($item);
                array_push($newArraySubject, $subjectNew->name);
            }
        }
        $newArrayClass = [];
        if ($records->class_id != null) {
            $makeClass = explode(',', $records->class_id);
            foreach ($makeClass as $item) {
                $classNew = ClassLevel::find($item);
                array_push($newArrayClass, $classNew->class);
            }
        }
        $newArrayTime = [];
        if ($records->time_tutor_id != null) {
            $makeTimetutor = explode(',', $records->time_tutor_id);
            foreach ($makeTimetutor as $item) {
                $timeNew = TimeSlot::find($item);
                array_push($newArrayTime, $timeNew->name);
            }
        }
        $newSchool = "";
        $newSalary = "";
        $newDistrict = "";
        if ($records->school_id != null) {
            $school = Schools::find($records->school_id);
            $newSchool = $school->name;
        }
        if ($records->salary_id != null) {
            $salary = RankSalary::find($records->salary_id);
            $newSalary = $salary->name;
        }
        if ($records->DistrictID != null) {
            $district = District::find($records->DistrictID);
            $newDistrict = $district->name;
        }
        if ($records->Certificate != null) {
            $Certificate = json_decode($records->Certificate);
        } else {
            $Certificate = [];
        }
        return  response()->json([
            'role' => $records->role,
            'gender' => $records->gender,
            'date_of_birth' => $records->date_of_birth,
            'name' => $records->name,
            'email' => $records->email,
            'avatar' => 'http://127.0.0.1:8000/storage/' . $records->avatar,
            'phone' => $records->phone,
            'address' => $records->address,
            'school_id' => $newSchool,
            'Citizen_card' => $records->Citizen_card,
            'education_level' => $records->education_level,
            'class_id' => $newArrayClass,
            'subject' => $newArraySubject,
            'salary_id' => $newSalary,
            'description' => $records->description,
            'time_tutor_id' => $newArrayTime,
            'status' => $records->status,
            'DistrictID' => $newDistrict,
            'Certificate' => $Certificate,
            'exp' => $records->exp,
            'current_role' => $records->current_role
        ], 200);
    }


    public function updateApi(UserRequest $request, String $id)
    {
        try {
            $user = User::find($id);
            $role = Role::find($request->role);
            if (!$role) {
                return response()->json('Sai quyền', 400);
            }
            $user->role = $role->name;
            $user->gender = $request->gender;
            $user->date_of_birth = $request->date_of_birth;
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $deleteImage = Storage::delete('/public/' . $user->avatar);
                if ($deleteImage) {
                    $user->avatar = uploadFile('hinh', $request->file('avatar'));
                }
            }
            $user->password = Hash::make($request->password);
            $user->address = $request->address;
            $user->DistrictID = $request->districtID;
            $user->phone = $request->phone;
            if ($request->role == 3) {
                $user->school_id = $request->school_id;
                $user->Citizen_card = $request->citizen_card;
                $user->education_level = $request->education_level;
                $class = implode(",", $request->class_id);
                $user->class_id = $request->$class;
                $subject = implode(",", $request->subject);
                $user->subject = $subject;
                $user->salary_id = $request->salary_id;
                $user->description = $request->description;
                $time_tutor = implode(",", $request->time_tutor_id);
                $user->time_tutor_id = $request->$time_tutor;
                $user->current_role = $request->current_role;
                $user->exp = $request->exp;
                $user->status = 1;
                if ($request->hasFile('Certificate')) {
                    $certificates = [];

                    foreach ($request->file('Certificate') as $file) {
                        if ($file->isValid()) {
                            $certificates = 'http://127.0.0.1:8000/storage/' . uploadFile('hinh', $file);
                        }
                    }
                    $user->Certificate = json_encode($certificates); // Lưu đường dẫn của các ảnh trong một mảng JSON
                } else {
                    $user->Certificate = $request->Certificate;
                }
            }
            $user->save();

            return response()->json("success", 201);
        } catch (\Exception $e) {
            return response()->json(['error' => "Sửa không thành công,$e"], 400);
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
    public function addNewUser(UserRequest $request)
    {
        $title = 'Thêm mới user';
        if ($request->isMethod('post')) {
            // dd($request);
            // $params = $request->post();
            $params = $request->except('_token');
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $params['avatar'] = uploadFile('hinh', $request->file('avatar'));
            } else {
                $params['avatar'] = "hinh/1699622845_avatar.jpg";
            }
            // dd($params);
            // unset($params['_token']);
            $user = new User();
            $user->role = $request->role;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->avatar = $request->avatar;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->fill($params);
            $user->save();
            if ($user->save()) {
                Session::flash('success', 'Thêm thành công!');
                return redirect()->route('search_user');
            } else {
                Session::flash('error', 'Thêm không thành công!');
            }
        }
        return view('backend.users.add', compact('title'));
    }
    public function updateUser(UserRequest $request, $id)
    {
        $title = 'Sửa User';
        $user = User::findOrFail($id);
        if ($request->isMethod('post')) {
            $user = User::find($id);
            $role = Role::find(2);
            if (!$role) {
                return response()->json('Sai quyền', 400);
            }
            $user->role = $role->name;
            $user->gender = $request->gender;
            $user->date_of_birth = $request->date_of_birth;
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $deleteImage = Storage::delete('/public/' . $user->avatar);
                if ($deleteImage) {
                    $user->avatar = uploadFile('hinh', $request->file('avatar'));
                }
            }
            $user->password = Hash::make($request->password);
            $user->address = $request->address;
            $user->DistrictID = $request->districtID;
            $user->phone = $request->phone;

            if ($user->save()) {
                Session::flash('success', 'Edit user success');
                return redirect()->route('search_user');
            } else {
                Session::flash('error', 'Edit subject error');
            }
        }
        return view('backend.users.edit', compact('title', 'user'));
    }
    public function delete($id)
    {
        if ($id) {
            $user = User::find($id);
            $deleted = $user->delete();
            if ($deleted) {
                Session::flash('success', 'Xoa thanh cong');
                return redirect()->route('search_user');
            } else {
                Session::flash('error', 'xoa that bai');
            }
        }
    }
    public function getAllTeacher()
    {
        $teachers = DB::table('users')
            ->where('role', 'teacher')
            ->where('status', '2')
            ->whereNull('deleted_at')
            ->get();
        if ($teachers) {
            $title = "Danh sách gia sư chờ phê duyệt";
            $view = 2;
            return view('backend.teacher.index', compact('teachers', 'title', 'view'));
        }
    }
    public function agree(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            Session::flash('success', 'success');
            $user->update(['status' => '1']);
            return redirect()->route('waiting');
        } else {
            Session::flash('error', 'error');
        }
    }
    public function getOneTeacherWaiting(Request $request,$id)
    {
        $records = User::where('id', $id)
            ->first();

        $newArraySubject = [];
        if ($records->subject != null) {
            $makeSubject = explode(',', $records->subject);
            foreach ($makeSubject as $item) {
                $subjectNew = Subject::find($item);
                array_push($newArraySubject, $subjectNew->name);
            }
        }
        $newArrayClass = [];
        if ($records->class_id != null) {
            $makeClass = explode(',', $records->class_id);
            foreach ($makeClass as $item) {
                $classNew = ClassLevel::find($item);
                array_push($newArrayClass, $classNew->class);
            }
        }
        $newArrayTime = [];
        if ($records->time_tutor_id != null) {
            $makeTimetutor = explode(',', $records->time_tutor_id);
            foreach ($makeTimetutor as $item) {
                $timeNew = TimeSlot::find($item);
                array_push($newArrayTime, $timeNew->name);
            }
        }
        $newSchool = "";
        $newSalary = "";
        $newDistrict = "";
        if ($records->school_id != null) {
            $school = Schools::find($records->school_id);
            $newSchool = $school->name;
        }
        if ($records->salary_id != null) {
            $salary = RankSalary::find($records->salary_id);
            $newSalary = $salary->name;
        }
//        if ($records->DistrictID != null) {
//            $district = District::find($records->DistrictID);
//            $newDistrict = $district->name;
//        }
        if ($records->Certificate) {
            $records->Certificate = [];
        }
        $data = [
            'id'=> $id,
            'role' => $records->role,
            'gender' => $records->gender,
            'date_of_birth' => $records->date_of_birth,
            'name' => $records->name,
            'email' => $records->email,
            'avatar' => 'http://127.0.0.1:8000/storage/' . $records->avatar,
            'phone' => $records->phone,
            'address' => $records->address,
            'school' => $newSchool,
            'Citizen_card' => $records->Citizen_card,
            'education_level' => $records->education_level,
            'class_id' => $newArrayClass,
            'subject' => $newArraySubject,
            'salary_id' => $newSalary,
            'description' => $records->description,
            'time_tutor_id' => $newArrayTime,
            'status' => $records->status,
            'DistrictID' => $newDistrict,
            'Certificate' => $records->Certificate,
            'current_role' => $records->current_role,
            'exp' => $records->exp
        ];
//        return $data;
            $title = "show Detail Teacher";
            return view('backend.teacher.show',compact('title','data'));
    }
}
