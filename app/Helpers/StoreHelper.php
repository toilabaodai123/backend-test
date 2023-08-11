<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Contracts\StoreHelperInterface;
use Exception;


class StoreHelper implements StoreHelperInterface
{
    public function validateStoreRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'is_online' => 'required'
        ]);

        if ($validator->fails()) {
            throw new Exception(__('validation.bad_credential'), 422);
        }
    }

    public function validateUpdateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_online' => 'required'
        ]);

        if ($validator->fails()) {
            throw new Exception(__('validation.bad_credential'),422);
        }
    }
}
