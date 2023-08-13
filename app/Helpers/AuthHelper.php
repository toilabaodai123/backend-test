<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;
use App\Contracts\AuthHelperInterface;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class AuthHelper implements AuthHelperInterface
{
    public function validateLoginRequest(Request $request)
    {
        $validator = Validator::make($request->all(),User::VALIDATION_LOGIN_RULES);
        if ($validator->fails()) {
            throw new Exception($validator->messages()->first(), 422);
        }
    }
}
