<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface ProductHelperInterface {
    public function validateStoreRequest(Request $request);
}