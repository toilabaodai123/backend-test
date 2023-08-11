<?php

namespace App\Repositories;

use App\Contracts\StoreRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Store;

class StoreRepository implements StoreRepositoryInterface {
    public function searchStore(int $user_id, Request $request)
    {
        $limitOfPagination = !empty($request->limit) ? $request->limit : 10;

        $stores = Store::where('user_id', $user_id);

        if (!empty($request->get(Store::NAME))) {
            $stores->where(Store::NAME, 'like', '%' . $request->get(Store::NAME) . '%');
        }

        if (!empty($request->get(Store::DESCRIPTION))) {
            $stores->where(Store::DESCRIPTION, 'like', '%' . $request->get(Store::DESCRIPTION) . '%');
        }

        if (!empty($request->get(Store::ADDRESS))) {
            $stores->where(Store::ADDRESS, 'like', '%' . $request->get(Store::ADDRESS) . '%');
        }

        if (!empty($request->get(Store::IS_ONLINE))) {
            $stores->where(Store::IS_ONLINE, $request->get(Store::IS_ONLINE) == "true" ? 1 : 0);
        }

        return $stores->paginate($limitOfPagination);
    }
}