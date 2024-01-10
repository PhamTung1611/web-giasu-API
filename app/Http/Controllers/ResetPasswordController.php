<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Notifications\ResetPasswordRequest;
use App\Models\HistorySendMail;

class ResetPasswordController extends Controller
{
    /**
     * Create token password reset.
     *
     * @param  ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function sendMail(Request $request)
    {

        try {
            $user = User::where('email', $request->email)->first();
            $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $user->code = $code;
            $user->notify(new ResetPasswordRequest($code));
            $new_history_sendmail = new HistorySendMail;
            $new_history_sendmail->id_user = $user->id;
            $new_history_sendmail->email = $user->email;
            $new_history_sendmail->type = '8';
            $new_history_sendmail->content = "Tài khoản của bạn bị từ chối vì lý do $request->reason";
            $new_history_sendmail->save();
            $user->update();
            return response()->json([
                'success'
            ]);
        } catch (\Exception $e) {
            // Handle other exceptions here
            return response()->json([
                'message' => 'User not found.'.$e
            ], 404); // You can choose an appropriate HTTP status code
        }
    }

    public function reset(Request $request)
    {
        try {
                $user= User::where('code',$request->code)->first();
                if($user){
                    $user->password = Hash::make($request->password);
                    $user->code=null;
                    $user->save();
                    return response()->json([
                        'success' => "oke",
                    ]);
                }else{
                    return response()->json('code sai',400);
                }


        }catch (\Exception $e) {
            // Handle other exceptions here
            return response()->json([
                'message' => 'Token invalid.'
            ], 404); // You can choose an appropriate HTTP status code
        }
    }
}
