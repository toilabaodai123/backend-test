<?php

namespace App\Contracts;
use Illuminate\Http\Request;


interface StoreRepositoryInterface
{
    public function searchStore(int $user_id,Request $request);
    public function findStoreWithStoreIdAndUserId(int $store_id,int $user_id);
    public function update(int $store_id,array $data);
    public function delete(int $store_id);
}
