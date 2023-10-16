<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
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

        // Tạo access token và refresh token
        $tokenResult = $user->createToken('MyAppToken');
        $token = $tokenResult->accessToken;
        $refreshToken = $tokenResult->refreshToken; // Lấy refresh token

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'refresh_token' => $refreshToken, // Trả về refresh token
            'expires_at' => $tokenResult->token->expires_at->toDateTimeString(),
        ]);
    }

    public function getUser(Request $request)
    {
        // Lấy thông tin người dùng từ access token
        $user = $request->user();

        // Trả về thông tin người dùng
        return response()->json(['user' => $user]);
    }
}
