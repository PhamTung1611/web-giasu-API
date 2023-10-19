<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

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

        return response()->json([
            'user' => $user,
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
                Passport::refreshToken()->create([
                    'id' => $refreshToken,
                    'revoked' => false, // Refresh token chưa bị thu hồi (revoke)
                    'expires_at' => now()->addDays(30), // Thời gian hết hạn của refresh token (30 ngày)
                    'user_id'=>$tokenResult->token->user_id,
                    'access_token_id'=> $tokenResult->accessToken
                ]);
                return response()->json([
                    'access_token' => $accessToken,
                    'refresh_token' => $refreshToken,
                ],200);
            }

            return response()->json([
                'message'=>'refreshtoken không tồn tại'
            ],400);
        }
    }
}
