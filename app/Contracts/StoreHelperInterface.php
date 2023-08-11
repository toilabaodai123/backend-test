<?php

namespace App\Contracts;
use Illuminate\Http\Request;

interface StoreHelperInterface {
    public function validateStoreRequest(Request $request);
    public function validateUpdateRequest(Request $request);
}