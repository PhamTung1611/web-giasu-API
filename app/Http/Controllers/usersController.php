<?php

namespace App\Http\Controllers;

use App\Mail\HTMLMail;
use App\Models\ClassLevel;
use App\Models\District;
use App\Models\Province;
use App\Models\RankSalary;
use App\Models\HistorySendMail;
use App\Models\Role;
use App\Models\Schools;
use App\Models\Subject;
use App\Models\TimeSlot;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Exception;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use phpseclib3\File\ASN1\Maps\UserNotice;
use App\Models\Education;
use App\Models\FeedBack;
use App\Models\History;
use App\Models\Job;

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
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => [1, 4]])) {
                //                 dd(123);
                $user = User::where('email', $request->email)->first();
                Session::put('email', $user->email);
                Session::put('role', $user->role);
                //  return view('dashboard');
                if($user->role ==1){
                    return redirect()->route('dashboard');
                }else{
                    return redirect()->route('waiting');
                };
                
            } else {
                //                 dd(432);
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

    public function depositInsertDatabase(Request $request)
    {
        $id = $request->input('id');
        $coin = $request->input('coin');

        $user = User::find($id);

        if ($user) {
            $user->coin += $coin;
            $user->save();

            return response()->json(['message' => 'Nạp tiền thành công'], 200);
        }
        return response()->json(['message' => 'Nạp tiền lỗi'], 400);
    }
    public function deposit(Request $request)
    {
        $vnp_Url = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $vnp_Returnurl = 'http://localhost:3000/profile/history';
        $vnp_TmnCode = 'YSRAA9QW'; //Mã website tại VNPAY
        $vnp_HashSecret = 'BWGVWFDPSGGASGPKLZMCMYEOHKLKHNFF'; //Chuỗi bí mật
        $data = $request->all();
        $vnp_TxnRef = rand(1, 10000); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 1;
        $vnp_OrderType = 'GS7';
        $vnp_Amount = $data['total'] * 100;
        $vnp_Locale = 'VN';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        //Billing
        $inputData = array(
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $vnp_TmnCode,
            'vnp_Amount' => $vnp_Amount,
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $vnp_IpAddr,
            'vnp_Locale' => $vnp_Locale,
            'vnp_OrderInfo' => $vnp_OrderInfo,
            'vnp_OrderType' => $vnp_OrderType,
            'vnp_ReturnUrl' => $vnp_Returnurl,
            'vnp_TxnRef' => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != '') {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != '') {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = '';
        $i = 0;
        $hashdata = '';
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . '=' . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . '?' . $query;
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
            $users = User::where('role', 2)->get();
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
    public function store(UserRequest $request, MailController $mailController)
    {
        try {
            $user = User::where('email',$request->email)->first();
            if(!$user){
                $user = new User;
            }
            $role = Role::find($request->role);
            if (!$role) {
                return response()->json('Sai quyền', 400);
            }
            $user->role = $request->role;
            $user->gender = $request->gender;
            $user->date_of_birth = $request->date_of_birth;
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $user->avatar = uploadFile('hinh', $request->file('avatar'));
            } else {
                $user->avatar = 'hinh/1699622845_avatar.jpg';
            }
            $user->password = Hash::make($request->password);
            $user->address = $request->address;
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            $user->District_ID = $request->DistrictID;
            $user->phone = $request->phone;
            if ($request->role == 3) {
                $user->exp = $request->exp;
                $user->current_role = $request->current_role;
                $user->school_id = $request->school_id;
                //                $user->Citizen_card = $request->citizen_card;
                $user->education_level = $request->education_level;
                $user->class_id = $request->class_id;
                $user->subject = $request->subject;
                $user->salary_id = $request->salary_id;
                $user->description = $request->description;
                $time_tutor = $request->time_tutor_id;
                $user->time_tutor_id = $time_tutor;
            }
            $user->status = 3;
            $user->save();
            $htmlContent = "
            <!DOCTYPE html>
<html>
<head>
    <title>Xác nhận tài khoản</title>
</head>
<body style='text-align:center'>
    <h2>GS7 Thông báo kích hoạt tài khoản.</h2>
    <h3>Tài khoản của bạn đã đăng ký trên hệ thống của chúng tôi nhưng chưa được kích hoạt.</h3>
    <div style='margin-top: 20px;'>
        <h3>Click để kích hoạt tài khoản:</h3>
        <form action='http://localhost:8000/api/users/status' method='get'>
            <input type='hidden' name='email' value='$request->email'>
            <button style='display: inline-block; font-size: 16px; padding: 10px 20px; text-decoration: none; background-color: #3498db; color: #ffffff; border-radius: 5px; border: 1px solid #3498db; cursor: pointer; transition: background-color 0.3s ease;' type='submit'>Xác nhận tài khoản</button>
        </form>
    </div>
</body>
</html>
";
            Mail::to($request->email)->send(new HTMLMail($htmlContent));
            $user_new = User::where('email',$request->email)->first();
            $new_history_sendmail = new HistorySendMail;
            $new_history_sendmail->id_user = $user_new->id;
            $new_history_sendmail->email = $request->email;
            $new_history_sendmail->type = 'Xác nhận đăng ký';
            $new_history_sendmail->content = "GS7 Thông báo kích hoạt tài khoản";
            $new_history_sendmail->save();
            return response()->json('success', 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 400);
        }
    }
    public function acceptcertificate($id){
        $user = User::find($id);
        $user->Certificate = $user->add_certificate;
        $user->add_certificate = null;
        $user->update();
        $htmlContent = "
        <!DOCTYPE html>
<html>
<head>
<title>GS7 thông báo </title>
</head>
<body style='text-align:center'>
<h2>GS7 Thông báo ảnh chứng chỉ.</h2>
<h3>Ảnh chứng chỉ của bạn đã được duyêt hãy truy cập hệ thống để kiểm tra nhé.</h3>
</body>
</html>
";
try {
    Mail::to($user->email)->send(new HTMLMail($htmlContent));
    $new_history_sendmail = new HistorySendMail;
    $new_history_sendmail->id_user = $id;
    $new_history_sendmail->email = $user->email;
    $new_history_sendmail->type = 'Thông báo ảnh chứng chỉ';
    $new_history_sendmail->content = "Ảnh chứng chỉ của bạn đã được duyêt hãy truy cập hệ thống để kiểm tra nhé";
    $new_history_sendmail->save();
    return redirect()->route('allcertificate');
} catch ( Exception $e) {
    // Xử lý lỗi ở đây, có thể ghi nhật ký lỗi hoặc thông báo cho người dùng
    return redirect()->route('allcertificate');
}
    }
    public function getallcertificate(Request $request){
        $user= User::whereNotNull('add_certificate')->get();
        $title = 'Danh sách ảnh chứng chỉ cần phê duyệt ';
        if ($request->email != '') {
            $search = User::where('email', 'LIKE', '%' . $request->get('email') . '%')
                ->whereNotNull('add_certificate')
                ->get();
            $user= $search;
        };
        return view('backend.certificate.index',compact('title','user'));
    }
    public function refusecertificate(Request $request){
        $user = User::find($request->id);
        $user->add_certificate = null;
        $user->update();
        $htmlContent = "
        <!DOCTYPE html>
<html>
<head>
<title>GS7 thông báo </title>
</head>
<body style='text-align:center'>
<h2>GS7 Thông báo ảnh chứng chỉ.</h2>
<h3>Ảnh chứng chỉ của bạn đã bị từ chối vì vì lý do $request->reason.</h3>
</body>
</html>
";
try {
    Mail::to($user->email)->send(new HTMLMail($htmlContent));
    $new_history_sendmail = new HistorySendMail;
    $new_history_sendmail->id_user = $request->id;
    $new_history_sendmail->email = $user->email;
    $new_history_sendmail->type = 'Thông báo ảnh chứng chỉ';
    $new_history_sendmail->content = "Ảnh chứng chỉ của bạn đã bị từ chối vì vì lý do $request->reason";
    $new_history_sendmail->save();
    return redirect()->route('allcertificate');
} catch ( Exception $e) {
    // Xử lý lỗi ở đây, có thể ghi nhật ký lỗi hoặc thông báo cho người dùng
    return redirect()->route('allcertificate');
}


    }
    public function getdetailcertificate($id){
        $title = 'Chi tiết chứng chỉ ';
        $user = User::find($id);
        $certificate =json_decode($user->add_certificate); 
        // dd($certificate);
        return view('backend.certificate.detail',compact('title','certificate','user'));
    }
    public function uploadCertificate(Request $request){
        $user = User::find($request->id);
       
        if ($user) {
            $currentCertificate = json_decode($user->add_certificate);
            // Thêm giá trị mới vào giá trị hiện tại
            if ($currentCertificate) {
                 foreach ($request->file('Certificate') as $file) {
                    $currentCertificate[] = 'http://127.0.0.1:8000/storage/' . uploadFile('hinh', $file);
                }

                $user->add_certificate = json_encode($currentCertificate);
                // Cập nhật trường Certificate_public với giá trị mới
                
            } else {
                $certificatenew=[];
                foreach ($request->file('Certificate') as $file) {
                    $certificatenew[] = 'http://127.0.0.1:8000/storage/' . uploadFile('hinh', $file);
                }

                $user->add_certificate = json_encode($certificatenew);
            }
            $user->update();
            return response()->json('success');
        }
        return response()->json('Không tồn tại user', 400);
    }
    public function updatestatusSendMail(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        $user->status = 2;
        $user->save();
        if ($user->role == 3){
            return redirect()->away('http://localhost:3000/auth/teacher');
        }else{
            return redirect()->away('http://localhost:3000/auth/user');
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
                // Kiểm tra xem $subjectNew có tồn tại không
                if ($subjectNew) {
                    array_push($newArraySubject, ['id' => $subjectNew->id, 'name' => $subjectNew->name]);
                }
            }
        }
        $newArrayEducation = [];
        if ($records->education_level != null) {
            $makeEducation = explode(',', $records->education_level);
            foreach ($makeEducation as $item) {
                $educationNew = Education::find($item);
                // Kiểm tra xem $subjectNew có tồn tại không
                if ($educationNew) {
                    array_push($newArrayEducation, ['id' => $educationNew->id, 'name' => $educationNew->name]);
                }
            }
        }
        $newArrayClass = [];
        if ($records->class_id != null) {
            $makeClass = explode(',', $records->class_id);
            foreach ($makeClass as $item) {
                $classNew = ClassLevel::find($item);
                // Kiểm tra xem $classNew có tồn tại không
                if ($classNew) {
                    array_push($newArrayClass, ['id' => $classNew->id, 'class' => $classNew->class]);
                }
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
        $newSchool = '';
        $newSalary = '';

        if ($records->school_id != null) {
            $school = Schools::find($records->school_id);
            $newSchool = $school->name;
        }
        // if ($records->salary_id != null) {
        //     $salary = RankSalary::find($records->salary_id);
        //     $newSalary = $salary->name;
        // }

        if ($records->Certificate != null) {
            $Certificate = [];
            foreach (json_decode($records->Certificate) as $key => $u) {
                array_push($Certificate, ['id' => $key + 1, 'path' => $u]);
            }
        } else {
            $Certificate = [];
        }
        if ($records->Certificate_public != null) {
            $Certificate_public = [];
            foreach (json_decode($records->Certificate_public) as $key => $u) {
                array_push($Certificate_public, ['id' => $key + 1, 'path' => $u]);
            }
        } else {
            $Certificate_public = [];
        }
        if ($records->add_certificate != null) {
            $Certificate_add = [];
            foreach (json_decode($records->add_certificate) as $key => $u) {
                array_push($Certificate_add, ['id' => $key + 1, 'path' => $u]);
            }
        } else {
            $Certificate_add = [];
        }
        $renter = DB::table('jobs')->where('id_teacher', $id)->count();
        // dd($renter);
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
            //            'Citizen_card' => $records->Citizen_card,
            'education_level' => $newArrayEducation,
            'class_id' => $newArrayClass,
            'subject' => $newArraySubject,
            'salary_id' => explode(',',$records->salary_id),
            'description' => $records->description,
            'time_tutor_id' => $newArrayTime,
            'status' => $records->status,
            'longitude' => $records->longitude,
            'latitude' => $records->latitude,
            'district' => $records->District_ID,
            'Certificate' => $Certificate,
            'exp' => $records->exp,
            'current_role' => $records->current_role,
            'coin' => $records->coin,
            'renter' => $renter,
            'Certificate_public' => $Certificate_public,
            'add_certificate'=>$Certificate_add,
            'status_public' => $records->status_certificate,
            'created_date' => $records->created_at
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
            $user->role = $request->role;
            $user->gender = $request->gender;
            $user->date_of_birth = $request->date_of_birth;
            $user->name = $request->name;
            if ($user->email != $request->email) {
                $user->email = $request->email;
            }

            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $deleteImage = Storage::delete('/public/' . $user->avatar);
                if ($deleteImage) {
                    $user->avatar = uploadFile('hinh', $request->file('avatar'));
                }
            }
            $user->password = Hash::make($request->password);
            $user->address = $request->address;
            $user->District_ID = $request->DistrictID;
            $user->phone = $request->phone;
            $user->longitude = $request->longitude;
            $user->latitude = $request->latitude;
            if ($request->role == 3) {
                $user->school_id = $request->school_id;
                $user->education_level = $request->education_level;
                $user->class_id = $request->class_id;
                $user->subject = $request->subject;
                $user->salary_id = $request->salary_id;
                $user->description = $request->description;
                $user->time_tutor_id = $request->time_tutor_id;
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
            $user->update();

            return response()->json('success', 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Sửa không thành công,$e'], 400);
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
                return response()->json('Xóa không thành công', 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }
    public function getAllUser(Request $request)
    {
        $title = 'Danh sách phụ huynh';
        $users = User::where('role', '2')->get();
        if ($request->post() && $request->search) {
            $users = DB::table('users')
                ->where('email', 'like', '%' . $request->search . '%')->get();
        }

        return view('backend.users.index', compact('users', 'title'));
    }
    public function addNewUser(UserRequest $request)
    {
        $title = 'Thêm mới phụ huynh';
        if ($request->isMethod('post')) {
            // dd($request);
            // $params = $request->post();
            $params = $request->except('_token');
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $params['avatar'] = uploadFile('hinh', $request->file('avatar'));
            } else {
                $params['avatar'] = 'hinh/1699622845_avatar.jpg';
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
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
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
    public function addNewCtv(UserRequest $request)
    {
        $title = 'Thêm mới cộng tác viên';
        if ($request->isMethod('post')) {
            // dd($request);
            // $params = $request->post();
            $params = $request->except('_token');
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $params['avatar'] = uploadFile('hinh', $request->file('avatar'));
            } else {
                $params['avatar'] = 'hinh/1699622845_avatar.jpg';
            }
            // dd($params);
            // unset($params['_token']);
            $user = new User();
            $user->role = 4;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->avatar = $request->avatar;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            $user->fill($params);
            $user->save();
            if ($user->save()) {
                Session::flash('success', 'Thêm thành công!');
                return redirect()->route('allctv');
            } else {
                Session::flash('error', 'Thêm không thành công!');
            }
        }
        return view('backend.ctv.add', compact('title'));
    }
    public function updateUser(UserRequest $request, $id)
    {
        $title = 'Sửa thông tin phụ huynh';
        $user = User::findOrFail($id);
        if ($request->isMethod('post')) {
            $user = User::find($id);
            $role = Role::find(2);
            if (!$role) {
                return response()->json('Sai quyền', 400);
            }
            $user->role = 2;
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
            $user->District_ID = $request->districtID;
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
    public function updateCtv(UserRequest $request, $id)
    {
        $title = 'Sửa cộng tác viên';
        $user = User::findOrFail($id);
        if ($request->isMethod('post')) {
            $user = User::find($id);
            $role = Role::find(2);
            if (!$role) {
                return response()->json('Sai quyền', 400);
            }
            $user->role = 4;
            $user->gender = $request->gender;
            $user->date_of_birth = $request->date_of_birth;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->status = $request->status;
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                $deleteImage = Storage::delete('/public/' . $user->avatar);
                if ($deleteImage) {
                    $user->avatar = uploadFile('hinh', $request->file('avatar'));
                }
            }
            $user->password = Hash::make($request->password);
            $user->address = $request->address;
            $user->District_ID = $request->districtID;
            $user->phone = $request->phone;

            if ($user->save()) {
                Session::flash('success', 'Edit user success');
                return redirect()->route('allctv');
            } else {
                Session::flash('error', 'Edit subject error');
            }
        }
        return view('backend.ctv.edit', compact('title', 'user'));
    }
    public function delete($id)
    {
        if ($id) {
            $user = User::find($id);
            $deleted = $user->delete();
            if ($deleted) {
                Session::flash('success', 'Xóa thành công');
                return redirect()->route('search_user');
            } else {
                Session::flash('error', 'xoa that bai');
            }
        }
    }
    public function delete_ctv($id)
    {
        if ($id) {
            $user = User::find($id);
            $deleted = $user->delete();
            if ($deleted) {
                Session::flash('success', 'Xóa thành công');
                return redirect()->route('allctv');
            } else {
                Session::flash('error', 'xoa that bai');
            }
        }
    }

    public function getAllTeacher()
    {
        $teachers = DB::table('users')
            ->where('status', 2)
            ->where('role',3)
            ->whereNull('deleted_at')
            ->get();
        if ($teachers) {
            $title = 'Danh sách gia sư chờ phê duyệt';
            $view = 2;
            return view('backend.teacher.waiting', compact('teachers', 'title', 'view'));
        }
    }
    public function agree(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            Session::flash('success', 'success');
            $email = Session::get('email');
            $user->status = 1;
            $user->assign_user = $email;
            $user->time_accept = now();
            $user->save();
            $htmlContent = '<h3>Tài khoản của bạn đã được duyệt, Hãy truy cập website để trải nghiệm nhé</h3>';
            Mail::to($user->email)->send(new HTMLMail($htmlContent));
            $new_history_sendmail = new HistorySendMail;
            $new_history_sendmail->id_user = $request->id;
            $new_history_sendmail->email = $user->email;
            $new_history_sendmail->type = 'Phê duyệt tài khoản';
            $new_history_sendmail->content = "Tài khoản của bạn đã được duyệt, Hãy truy cập website để trải nghiệm nhé";
            $new_history_sendmail->save();
            if($request->agree == 'true'){
                return redirect()->route('giasutuchoi');
            }
            return redirect()->route('waiting');
        } else {
            Session::flash('error', 'error');
        }
    }
    public function activateCtv($id)
    {
        $user = User::find($id);
        $user->status = 1;
        $user->save();
        return redirect()->route('allctv');
    }

    public function deactivateCtv($id)
    {
        $user = User::find($id);
        $user->status = 0;
        $user->save();
        return redirect()->route('allctv');
    }
    public function getOneTeacherWaiting(Request $request, $id)
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
        $newSchool = '';
        $newSalary = '';
        $newDistrict = '';
        if ($records->school_id != null) {
            $school = Schools::find($records->school_id);
            $newSchool = $school->name;
        }
        // if ($records->salary_id != null) {
        //     $salary = RankSalary::find($records->salary_id);
        //     $newSalary = $salary->name;
        // }
        //        if ($records->DistrictID != null) {
        //            $district = District::find($records->DistrictID);
        //            $newDistrict = $district->name;
        //        }

        if (!$records->Certificate) {
            $records->Certificate = '';
        } else {
            $records->Certificate = json_decode($records->Certificate);
        }
        $data = [
            'id' => $id,
            'role' => $records->role,
            'gender' => $records->gender,
            'date_of_birth' => $records->date_of_birth,
            'name' => $records->name,
            'email' => $records->email,
            'avatar' => 'http://127.0.0.1:8000/storage/' . $records->avatar,
            'phone' => $records->phone,
            'address' => $records->address,
            'school' => $newSchool,
            //            'Citizen_card' => $records->Citizen_card,
            'education_level' => $records->education_level,
            'class_id' => $newArrayClass,
            'subject' => $newArraySubject,
            'salary_id' => explode(',',$records->salary_id),
            'description' => $records->description,
            'time_tutor_id' => $newArrayTime,
            'status' => $records->status,
            'DistrictID' => $records->District_ID,
            'longitude' => $records->longitude,
            'latitude' => $records->latitude,
            'Certificate' => $records->Certificate,
            'current_role' => $records->current_role,
            'exp' => $records->exp

        ];
        //        return $data;
        $title = 'show Detail Teacher';
        if($records->status== 5){
            return view('backend.tuchoigiasu.show', compact('title', 'data'));
        }
        return view('backend.teacher.show', compact('title', 'data'));
    }
    public function updatestatus(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->status = $request->status;
            $user->save();
            return response()->json('success');
        } else {
            return response()->json('error', 400);
        }
    }
    public function getAllCtv(Request $request)
    {
        $users = User::where('role', 4)->get();
        $view = 3;
        $title = 'Danh sách cộng tác viên';
        if ($request->post() && $request->search) {
            $users = DB::table('users')
                ->where('email', 'like', '%' . $request->search . '%')
                ->where('role', 4)
                ->get();
        }
        return view('backend.ctv.index', compact('users', 'view', 'title'));
    }
    public function showCtvByStatus($status)
    {
        $title = 'Danh sach';
        $users = User::where('status', $status)->where('role', 4)->get();
        return view('backend.ctv.index', compact('users', 'title'));
    }
    public function showTeacherByStatus($status)
    {
        $view = 1;

        $title = 'Danh sách giáo viên';
        $subject = Subject::get();
        $class = ClassLevel::get();
        $teachers = User::where('status', $status)->where('role', 3)->get();
        return view('backend.teacher.index', compact('teachers', 'title', 'subject', 'class', 'view'));
    }
    public function certificate_public(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $currentCertificate = json_decode($user->Certificate_public);
            // Thêm giá trị mới vào giá trị hiện tại
            if ($currentCertificate) {
                $newCertificate = $request->Certificate_public;
                foreach ($newCertificate as $v) {
                    $currentCertificate[] = $v;
                }


                // Cập nhật trường Certificate_public với giá trị mới
                $user->Certificate_public = json_encode($currentCertificate);
            } else {
                $user->Certificate_public = $request->Certificate_public;
            }

            $user->update();
            return response()->json('success');
        }
        return response()->json('Không tồn tại user', 400);
    }
    public function status_certificate(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->status_certificate = $request->status_certificate;
            $user->update();
            return response()->json('success');
        }
        return response()->json('Không tồn tại user', 400);
    }
    public function delete_certificate(Request $request, $id)
    {
        $user = User::find($id);
        $currentCertificate = json_decode($user->Certificate_public);
        $certificatesToDelete = $request->delete_certificate;
        // dd($request->delete_certificate);
        // Tạo một mảng mới chứa các phần tử không bị xóa
        $updatedCertificates = array_filter($currentCertificate, function ($item) use ($certificatesToDelete) {
            return !in_array($item, $certificatesToDelete);
        });
        if($updatedCertificates!=[]){
            $user->Certificate_public = json_encode(array_values($updatedCertificates));
        }else{
            $user->Certificate_public=null;
        }
        // Cập nhật lại trường Certificate_public trong cơ sở dữ liệu
        
        $user->save();
        return response()->json('success');
    }
    public function getallteacherwaiting(){
        $teachers = DB::table('users')
        ->where('status', 5)
        ->whereNull('deleted_at')
        ->get();
    if ($teachers) {
        $title = 'Danh sách gia sư không được duyệt';
        return view('backend.tuchoigiasu.waiting', compact('teachers', 'title'));
    }
        
    }
}
