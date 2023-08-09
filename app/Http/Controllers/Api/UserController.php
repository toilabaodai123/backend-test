<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function createUser(UserRegisterRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'User Created Successfully',
            'data' => [
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ]
        ], 200);
    }

    public function loginUser(UserLoginRequest $request)
    {
        $request->validated();

        if (!Auth::attempt($request->only(['email', 'password']))) {
            throw ValidationException::withMessages([
                'message' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'message' => 'User Logged In Successfully',
            'data' => [
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ]
        ], 200);
    }

    public function logoutUser(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'User logged out successfully',
        ], 200);
    }

    public function showUserInfo(Request $request){
        return $request->user();
    }
}
