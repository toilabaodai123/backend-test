<?php

namespace App\Contracts;
use Illuminate\Http\Request;


interface StoreRepositoryInterface
{
    public function searchStore(int $user_id,Request $request);
}
