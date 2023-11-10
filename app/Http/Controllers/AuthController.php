<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use App\Models\Schools;
use App\Models\District;
use App\Models\ClassLevel;
use App\Models\RankSalary;
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
            return response()->json(['message' => 'Unauthorized'], 401);
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
        if($user->DistrictID){
            $distric = District::find($user->DistrictID);
            $districName = $distric->name;
        }else{
            $districName ="";
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
                'District'=>$districName,
                'Certificate'=>$user->Certificate,
                'avatar'=>'http://127.0.0.1:8000/storage/'.$user->avatar,
                'name'=>$user->name,
                'email'=>$user->email,
                'phone'=>$user->phone,
                'time_tutor'=>$newTimetutor],
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
                if($user->DistrictID){
                    $distric = District::find($user->DistrictID);
                    $districName = $distric->name;
                }else{
                    $districName ="";
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
                        'District'=>$districName,
                        'Certificate'=>$user->Certificate,
                        'avatar'=>'http://127.0.0.1:8000/storage/'.$user->avatar,
                        'name'=>$user->name,
                        'email'=>$user->email,
                        'phone'=>$user->phone,
                        'time_tutor'=>$newTimetutor],

                    'access_token' => $tokenResult->accessToken,
                    'refresh_token' => $tokennew->id,

                ]);
            }

        }
        return response()->json([
            'message'=>'refreshtoken không tồn tại'
        ],400);
    }
}
