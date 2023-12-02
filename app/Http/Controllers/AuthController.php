<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\HTMLMail;
use App\Models\Province;
use App\Models\Role;
use App\Models\Subject;
use App\Models\TimeSlot;
use App\Models\User;
use App\Models\Ward;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\Passport;
use App\Models\Schools;
use App\Models\District;
use App\Models\ClassLevel;
use App\Models\RankSalary;
use Laravel\Socialite\Facades\Socialite;
require_once '../vendor/autoload.php';
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
//        dd(Hash::make('12345'));
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Email hoặc password không tồn tại'], 401);
        }
        $users = DB::table('users')->where('email', $request->email)->first();
        if ($users->status == 0){
            return response()->json(['message' => 'Tài khoản bị vô hiệu hóa'], 401);
        }
        $user = $request->user();
        // Create an access token and a refresh token
        $tokenResult = $user->createToken('MyAppToken'); // Pass a token name here
        $refreshToken = Passport::refreshToken()->create([
            'id' => $tokenResult->token->id,
            'revoked' => false, // Refresh token chưa bị thu hồi (revoke)
            'expires_at' => now()->addSeconds(2000), // Thời gian hết hạn của refresh token
            'user_id'=>$tokenResult->token->user_id,
            'access_token_id'=> $tokenResult->accessToken
        ]);
        if($user->school_id){
            $school = Schools::find($user->school_id);
            $schoolName = $school->name;
        }else{
            $schoolName = "";
        }


        if ($user->class_id){
            $classArray = explode(',',$user->class_id);
            $newClassArray =new Collection();
            foreach ($classArray as $item) {
                $class = ClassLevel::find($item);
                $newClassArray->push($class->class);
            }
        }else{
            $newClassArray= [];
        }
       if($user->subject){
           $subjectArray = explode(',',$user->subject);
           $newSubjectArray =new Collection();
           foreach ($subjectArray as $item) {
               $newSubjectArray->push($item);
           }
       }else{
           $newSubjectArray=[];
       }
        if($user->time_tutor_id){
            $timetutorArray = explode(',',$user->time_tutor_id);
            $newTimetutor =new Collection();
            foreach ($timetutorArray as $item) {
                $time = TimeSlot::find($item);
                $newTimetutor->push($time->name);
            }
        }else{
            $newTimetutor =[];
        }
       if($user->salary_id){
           $rank = RankSalary::find($user->salary_id);
           $rankName = $rank->name;
       }else{
           $rankName ="";
       }

        return response()->json([
            'user'=>[
                'id'=>$user->id,
                'role'=>$user->role,
                'address'=>$user->address,
                'school' => $schoolName,
                'citizen_card'=>$user->Citizen_card,
                'education_level'=>$user->education_level,
                'class'=> $newClassArray,
                'subject'=>$newSubjectArray,
                'salary'=>$rankName,
                'description'=>$user->description,
                'District'=>$user->DistrictID,
                'longitude'=>$user->longitude,
                'latitude'=>$user->latitude,
                'Certificate'=>$user->Certificate,
                'avatar'=>'http://127.0.0.1:8000/storage/'.$user->avatar,
                'name'=>$user->name,
                'email'=>$user->email,
                'phone'=>$user->phone,
                'time_tutor'=>$newTimetutor,
                'coin'=>$users->coin
            ],
            'access_token' => $tokenResult->accessToken,
            'refresh_token' => $refreshToken->id,

        ]);
    }
    public function RefreshToken(Request $request)
    {
        // Lấy dữ liệu từ bảng oauth_refresh_tokens dựa trên ID
        $refreshTokenData = DB::table('oauth_refresh_tokens')
            ->where('id', $request->input('refresh_token_id'))
            ->where('revoked',0)
            ->first();
        // Kiểm tra nếu có dữ liệu và trả về refresh token nếu có
        if ($refreshTokenData) {
            DB::table('oauth_refresh_tokens')
                ->where('id', $request->input('refresh_token_id'))
                ->update(['revoked' => true]);
            $user = User::find($refreshTokenData->user_id);
            if ($user) {
                $tokenResult = $user->createToken('MyAppToken');
                $accessToken = $tokenResult->accessToken;
                $refreshToken = $tokenResult->token->id;
                $tokennew =Passport::refreshToken()->create([
                    'id' => $refreshToken,
                    'revoked' => false, // Refresh token chưa bị thu hồi (revoke)
                    'expires_at' => now()->addDays(30), // Thời gian hết hạn của refresh token (30 ngày)
                    'user_id'=>$tokenResult->token->user_id,
                    'access_token_id'=> $tokenResult->accessToken
                ]);
                if($user->school_id){
                    $school = Schools::find($user->school_id);
                    $schoolName = $school->name;
                }else{
                    $schoolName = "";
                }

                if ($user->class_id){
                    $classArray = explode(',',$user->class_id);
                    $newClassArray =new Collection();
                    foreach ($classArray as $item) {
                        $class = ClassLevel::find($item);
                        $newClassArray->push($class->class);
                    }
                }else{
                    $newClassArray= [];
                }
                if($user->subject){
                    $subjectArray = explode(',',$user->subject);
                    $newSubjectArray =new Collection();
                    foreach ($subjectArray as $item) {
                        $sub = Subject::find($item);
                        $newSubjectArray->push($sub->name);
                    }
                }else{
                    $newSubjectArray=[];
                }
                if($user->time_tutor_id){
                    $timetutorArray = explode(',',$user->time_tutor_id);
                    $newTimetutor =new Collection();
                    foreach ($timetutorArray as $item) {
                        $time = TimeSlot::find($item);
                        $newTimetutor->push($time->name);
                    }
                }else{
                    $newTimetutor =[];
                }
                if($user->salary_id){
                    $rank = RankSalary::find($user->salary_id);
                    $rankName = $rank->name;
                }else{
                    $rankName ="";
                }
                return response()->json([
                    'user'=>[
                        'id'=>$user->id,
                        'role'=>$user->role,
                        'address'=>$user->address,
                        'school' => $schoolName,
                        'citizen_card'=>$user->Citizen_card,
                        'education_level'=>$user->education_level,
                        'class'=> $newClassArray,
                        'subject'=>$newSubjectArray,
                        'salary'=>$rankName,
                        'description'=>$user->description,
                        'District'=>$user->DistrictID,
                        'longitude'=>$user->longitude,
                        'Certificate'=>$user->Certificate,
                        'latitude'=>$user->latitude,
                        'avatar'=>'http://127.0.0.1:8000/storage/'.$user->avatar,
                        'name'=>$user->name,
                        'email'=>$user->email,
                        'phone'=>$user->phone,
                        'time_tutor'=>$newTimetutor,
                        'coin'=>$user->coin,
                    ],
                    'access_token' => $tokenResult->accessToken,
                    'refresh_token' => $tokennew->id,

                ]);
            }

        }
        return response()->json([
            'message'=>'refreshtoken không tồn tại'
        ],400);
    }
    public function loginCallback(Request $request)
    {

        try {
            $state = $request->input('state');

            parse_str($state, $result);
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->email)->first();
            if ($user) {
                $tokenResult = $user->createToken('MyAppToken');
                $accessToken = $tokenResult->accessToken;
                $refreshToken = $tokenResult->token->id;
                $tokennew =Passport::refreshToken()->create([
                    'id' => $refreshToken,
                    'revoked' => false, // Refresh token chưa bị thu hồi (revoke)
                    'expires_at' => now()->addDays(30), // Thời gian hết hạn của refresh token (30 ngày)
                    'user_id'=>$tokenResult->token->user_id,
                    'access_token_id'=> $tokenResult->accessToken
                ]);
                if($user->school_id){
                    $school = Schools::find($user->school_id);
                    $schoolName = $school->name;
                }else{
                    $schoolName = "";
                }

                if ($user->class_id){
                    $classArray = explode(',',$user->class_id);
                    $newClassArray =new Collection();
                    foreach ($classArray as $item) {
                        $class = ClassLevel::find($item);
                        $newClassArray->push($class->class);
                    }
                }else{
                    $newClassArray= [];
                }
                if($user->subject){
                    $subjectArray = explode(',',$user->subject);
                    $newSubjectArray =new Collection();
                    foreach ($subjectArray as $item) {
                        $sub = Subject::find($item);
                        $newSubjectArray->push($sub->name);
                    }
                }else{
                    $newSubjectArray=[];
                }
                if($user->time_tutor_id){
                    $timetutorArray = explode(',',$user->time_tutor_id);
                    $newTimetutor =new Collection();
                    foreach ($timetutorArray as $item) {
                        $time = TimeSlot::find($item);
                        $newTimetutor->push($time->name);
                    }
                }else{
                    $newTimetutor =[];
                }
                if($user->salary_id){
                    $rank = RankSalary::find($user->salary_id);
                    $rankName = $rank->name;
                }else{
                    $rankName ="";
                }
                return response()->json([
                    'user'=>[
                        'id'=>$user->id,
                        'role'=>$user->role,
                        'address'=>$user->address,
                        'school' => $schoolName,
                        'citizen_card'=>$user->Citizen_card,
                        'education_level'=>$user->education_level,
                        'class'=> $newClassArray,
                        'subject'=>$newSubjectArray,
                        'salary'=>$rankName,
                        'description'=>$user->description,
                        'District'=>$user->DistrictID,
                        'longitude'=>$user->longitude,
                        'latitude'=>$user->latitude,
                        'Certificate'=>$user->Certificate,
                        'avatar'=>'http://127.0.0.1:8000/storage/'.$user->avatar,
                        'name'=>$user->name,
                        'email'=>$user->email,
                        'phone'=>$user->phone,
                        'time_tutor'=>$newTimetutor,
                        'coin'=>$user->coin
                    ],
                    'tinhtrang'=>'oke',
                    'access_token' => $accessToken,
                    'refresh_token' => $tokennew->id,

                ]);

            }
            $usernew = User::create(
                [
                    'email' => $googleUser->email,
                    'name' => $googleUser->name,
                    'google_id'=> $googleUser->id,
                    'role' => 'user',
                    'status'=>1,
                ]
            );
            $client = new Google_Client();
//            $client->setAuthConfig('../client_credentials.json');
//            $client->addScope('https://www.googleapis.com/auth/user.addresses.read');
//            $client->setRedirectUri('http://localhost:8000/api/callback');
//            $client->setAccessToken($googleUser->token);
//            $service = new \Google\Service\PeopleService($client);
//            $connections = $service->people_connections->listPeopleConnections('people/me', [
//                'personFields' => 'addresses',
//            ]);
//
//            $addresses = $connections->getAddresses();
//            if ($addresses) {
//                // Lấy địa chỉ từ kết quả
//                $address = $addresses[0]['formattedValue']; // Lấy địa chỉ từ kết quả đầu tiên
//
//                // Sử dụng Google Maps Geocoding API để lấy tọa độ từ địa chỉ
//                $geocodeResponse = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&key=YOUR_API_KEY');
//                $geocodeData = json_decode($geocodeResponse);
//
//                if ($geocodeData && $geocodeData->status === 'OK') {
//                    $latitude = $geocodeData->results[0]->geometry->location->lat;
//                    $longitude = $geocodeData->results[0]->geometry->location->lng;
//
//                    // Cập nhật thông tin người dùng với địa chỉ và tọa độ mới
//                    $user->address = $address;
//                    $user->latitude = $latitude;
//                    $user->longitude = $longitude;
//                    $user->save();
//                }
                $tokenResult = $usernew->createToken('MyAppToken');

                $accessToken = $tokenResult->accessToken;
                $refreshToken = $tokenResult->token->id;
                $tokennew = Passport::refreshToken()->create([
                    'id' => $refreshToken,
                    'revoked' => false, // Refresh token chưa bị thu hồi (revoke)
                    'expires_at' => now()->addDays(30), // Thời gian hết hạn của refresh token (30 ngày)
                    'user_id' => $tokenResult->token->user_id,
                    'access_token_id' => $tokenResult->accessToken
                ]);
                return response()->json([
                    'status' => __('google sign in successful'),
                    'data' => $usernew,
                    'tinhtrang' => 'thieuthongtin',
                    'access_token' => $accessToken,
                    'refresh_token' => $tokennew->id,
                ], Response::HTTP_CREATED);
//            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => __('google sign in failed'),
                'error' => $exception,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    public function addInfo(UserRequest $request ){
        try {
            $user = User::where('google_id',$request->google_id);
            if ($user){
                $role = Role::find($request->role);
                //            dd($role->name);
                if (!$role) {
                    return response()->json('Sai quyền', 400);
                }
                $user->role = 'user';
                $user->gender = $request->gender;
                $user->date_of_birth = $request->date_of_birth;
                if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                    $user->avatar = uploadFile('hinh', $request->file('avatar'));
                } else {
                    $user->avatar = "hinh/1699622845_avatar.jpg";
                }
                $user->password = Hash::make($request->password);
                $user->address = $request->address;
                $user->latitude = $request->latitude;
                $user->longitude = $request->longitude;
                $user->DistrictID = $request->DistrictID;
                $user->phone = $request->phone;
                $user->status = 1;
                $user->save();
            }
            else{
                return response()->json(['error' => "Không tồn tại user"], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => "Thêm không thành công,$e"], 400);
        }
    }
    public function getGoogleSignInUrl()
    {
        try {
            $url = Socialite::driver('google')->stateless()
                ->redirect()->getTargetUrl();
            return response()->json([
                'url' => $url,
            ])->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $exception;
        }
    }
    public function updatePassword(Request $request){
        $user = User::find($request->id);
        if($user){
            if (Hash::check($request->passwordlast,$user->password)){
                $user->password = Hash::make($request->password);
                $user->save();
            }else{
                return response()->json('Sai password', 400);
            }

            return response()->json('edit password success');
        }else {
            return response()->json('edit password error',400);
        }
    }
}
