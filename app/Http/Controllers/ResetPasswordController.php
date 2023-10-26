<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
            $passwordReset = PasswordReset::updateOrCreate([
                'email' => $user->email,
            ], [
                'token' => Str::random(60),
            ]);
            if ($passwordReset) {
                $user->notify(new ResetPasswordRequest($passwordReset->token));
            }

            return response()->json([
                'message' => 'We have e-mailed your password reset link!'
            ]);
        } catch (\Exception $e) {
            // Handle other exceptions here
            return response()->json([
                'message' => 'User not found.'
            ], 404); // You can choose an appropriate HTTP status code
        }
    }

    public function reset(Request $request, $token)
    {
        try {
            $passwordReset = PasswordReset::where('token', $token)->first();
            if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
                $passwordReset->delete();

                return response()->json([
                    'message' => 'This password reset token is invalid.',
                ], 422);
            }
            $user = User::where('email', $passwordReset->email)->firstOrFail();
            $updatePasswordUser = $user->update($request->only('password'));
            $passwordReset->delete();
            return response()->json([
                'success' => $updatePasswordUser,
            ]);
        }catch (\Exception $e) {
            // Handle other exceptions here
            return response()->json([
                'message' => 'Token invalid.'
            ], 404); // You can choose an appropriate HTTP status code
        }
    }
}
