<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface AuthHelperInterface {
    public function validateLoginRequest(Request $request);
}