<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Contracts\StoreHelperInterface;
use App\Models\Store;
use Exception;


class StoreHelper implements StoreHelperInterface
{
    public function validateStoreRequest(Request $request)
    {
        $validator = Validator::make($request->all(),Store::VALIDATION_STORE_RULES);
        if ($validator->fails()) {
            throw new Exception(__('validation.bad_credential'), 422);
        }
    }

    public function validateUpdateRequest(Request $request)
    {
        $validator = Validator::make($request->all(),Store::VALIDATION_UPDATE_RULES);

        if ($validator->fails()) {
            throw new Exception(__('validation.bad_credential'),422);
        }
    }
}
