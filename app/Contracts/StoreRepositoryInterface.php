<?php

namespace App\Contracts;
use Illuminate\Http\Request;


interface StoreRepositoryInterface extends BaseRepositoryInterface
{
    public function searchStore(int $user_id,Request $request);
    public function findStoreWithStoreIdAndUserId(int $store_id,int $user_id);
}
