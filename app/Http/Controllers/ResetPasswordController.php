<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Notifications\ResetPasswordRequest;


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
