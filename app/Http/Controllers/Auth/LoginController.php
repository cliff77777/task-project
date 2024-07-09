<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // 認證成功，生成 Passport 的 Access Token
            $accessToken = Auth::user()->createToken('authToken')->accessToken;
            return response()->json(['access_token' => $accessToken], 200);
        }

        // 認證失敗處理
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
