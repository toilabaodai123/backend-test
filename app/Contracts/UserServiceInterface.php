<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface UserServiceInterface {
    public function store(Request $request);
}