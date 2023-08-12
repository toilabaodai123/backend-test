<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Contracts\UserSwaggerInterface;

class UserController extends Controller implements UserSwaggerInterface 
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),User::VALIDATION_STORE_RULES);

        if ($validator->fails()) {
            return response()->json([
                'message' => __('validation.bad_credential'),
                'data' => [
                    'error' => $validator->errors(),
                ]
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => __('user.create.success'),
            'data' => [
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ]
        ], 200);
    }
}
