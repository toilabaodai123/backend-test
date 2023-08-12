<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function store(Request $request)
    {
        $response = null;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $response = $user->createToken("API TOKEN")->plainTextToken;

        return $response;
    }
}
