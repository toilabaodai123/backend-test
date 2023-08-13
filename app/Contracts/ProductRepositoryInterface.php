<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface ProductRepositoryInterface extends BaseRepositoryInterface {
    public function searchProduct(int $user_id,Request $request);
}