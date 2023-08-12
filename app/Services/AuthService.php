<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;

class AuthService implements AuthServiceInterface{
    public function login(Request $request)
    {
        $response = null;

        if (!Auth::attempt($request->only(['email', 'password']))) {
            throw new Exception(__('auth.wrong_credential'),401);
        }

        $user = User::where('email', $request->email)->first();

        $response = $user->createToken("API TOKEN")->plainTextToken;

        return $response;
    }

    public function logout(Request $request)
    {
        $response = null;

        $request->user()->currentAccessToken()->delete();

        return $response;
    }    
}