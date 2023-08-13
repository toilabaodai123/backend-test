<?php

namespace App\Helpers;

use App\Contracts\ProductHelperInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Exception;

class ProductHelper implements ProductHelperInterface
{
    public function validateStoreRequest(Request $request)
    {
        $validator = Validator::make($request->all(), Product::VALIDATION_STORE_RULES);

        if ($validator->fails()) {
            throw new Exception($validator->messages()->first(), 422);
        }
    }
}
