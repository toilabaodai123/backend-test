<?php

namespace App\Helpers;

use App\Contracts\UserHelperInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Exception;

class UserHelper implements UserHelperInterface
{
    public function validateStoreRequest(Request $request)
    {
        $validator = Validator::make($request->all(),User::VALIDATION_STORE_RULES);

        if ($validator->fails()) {
            throw new Exception($validator->messages()->first(),422);
        }
    }
}
