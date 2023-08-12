<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface AuthServiceInterface { 
    public function login(Request $request);
    public function logout(Request $request);
}