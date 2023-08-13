<?php

namespace App\Repositories;

use App\Contracts\StoreRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\User;

/**
 * StoreRepository
 */
class StoreRepository extends BaseRepository implements StoreRepositoryInterface
{
    public function __construct(Store $store)
    {
        $this->setModel($store);
    }

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

        $stores = Store::where('user_id', $user_id);

        if (!empty($request->get('name'))) {
            $stores->where('name', 'like', '%' . $request->get('name') . '%');
        }

        if (!empty($request->get('description'))) {
            $stores->where('description', 'like', '%' . $request->get('description') . '%');
        }

        if (!empty($request->get('address'))) {
            $stores->where('address', 'like', '%' . $request->get('address') . '%');
        }

        if (!empty($request->get('is_online'))) {
            $stores->where('is_online', $request->get('is_online') == "true" ? 1 : 0);
        }

        return $stores->paginate($limitOfPagination);
    }

    public function findStoreWithStoreIdAndUserId(int $store_id, int $user_id)
    {
        return Store::where('id', $store_id)->where('user_id', $user_id)->first();
    }
}
