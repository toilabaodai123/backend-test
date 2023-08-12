<?php

namespace App\Repositories;

use App\Contracts\StoreRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\User;

/**
 * StoreRepository
 */
class StoreRepository implements StoreRepositoryInterface
{
    /**
     * searchStore
     *
     * @param  mixed $user_id
     * @param  mixed $request
     * @return void
     */
    public function searchStore(int $user_id, Request $request)
    {
        $limitOfPagination = !empty($request->limit) ? $request->limit : 10;

        $stores = Store::where(Store::COLUMN_USER_ID, $user_id);

        if (!empty($request->get(Store::COLUMN_NAME))) {
            $stores->where(Store::COLUMN_NAME, 'like', '%' . $request->get(Store::COLUMN_NAME) . '%');
        }

        if (!empty($request->get(Store::COLUMN_DESCRIPTION))) {
            $stores->where(Store::COLUMN_DESCRIPTION, 'like', '%' . $request->get(Store::COLUMN_DESCRIPTION) . '%');
        }

        if (!empty($request->get(Store::COLUMN_ADDRESS))) {
            $stores->where(Store::COLUMN_ADDRESS, 'like', '%' . $request->get(Store::COLUMN_ADDRESS) . '%');
        }

        if (!empty($request->get(Store::COLUMN_IS_ONLINE))) {
            $stores->where(Store::COLUMN_IS_ONLINE, $request->get(Store::COLUMN_IS_ONLINE) == "true" ? 1 : 0);
        }

        return $stores->paginate($limitOfPagination);
    }

    public function findStoreWithStoreIdAndUserId(int $store_id, int $user_id)
    {
        return Store::where(Store::COLUMN_ID, $store_id)->where(Store::COLUMN_USER_ID, $user_id)->first();
    }

    public function update(int $store_id, array $data)
    {
        $store = tap(Store::where(Store::COLUMN_ID, $store_id))->update($data);

        return $store;
    }

    public function delete(int $store_id)
    {
        $store = Store::where(Store::COLUMN_ID, $store_id)->delete();

        return $store;
    }

    public function create(array $data)
    {
        $store = Store::create($data);

        return $store;
    }
}
