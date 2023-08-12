<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface UserHelperInterface {
    public function validateStoreRequest(Request $request);
}