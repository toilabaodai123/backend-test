<?php

namespace App\Services;


use Illuminate\Http\Request;
use App\Models\Store;
use Exception;

class StoreService implements \App\Contracts\StoreServiceInterface
{

    public function index(Request $request)
    {
        $user = $request->user();

        $limitOfPagination = !empty($request->limit) ? $request->limit : 10;

        $stores = Store::where('user_id', $user->id);

        if (!empty($request->name)) {
            $stores->where('name', 'like', '%' . $request->name . '%');
        }

        if (!empty($request->description)) {
            $stores->where('description', 'like', '%' . $request->description . '%');
        }

        if (!empty($request->address)) {
            $stores->where('address', 'like', '%' . $request->address . '%');
        }

        if (!empty($request->is_online)) {
            $stores->where('is_online', $request->is_online == "true" ? 1 : 0);
        }

        return $stores->paginate($limitOfPagination);
    }

    public function show(int $id, Request $request)
    {
        $user = $request->user();

        if (empty($store = Store::where('id', $id)->where('user_id', $user->id)->first())) {
            throw new Exception(__('store.show.not_found'), 404);
        }

        return $store;
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $store = Store::create([
            'name' => $request->name,
            'user_id' => $user->id,
            'description' => $request->description ?? "",
            'address' => $request->address ?? "",
            'is_online' => (bool)$request->is_online
        ]);

        return $store;
    }

    public function update(int $id, Request $request)
    {
        $user = $request->user();

        if (empty($store = Store::where('id', $id)->where('user_id', $user->id)->first())) {
            throw new Exception(__('store.update.not_found'),404);
        }

        $store->update([
            'name' => $request->name ? $request->name : $store->name,
            'description' => $request->description ? $request->description : $store->description,
            'address' => $request->address ? $request->address : $store->address,
            'is_online' => (boolean)$request->is_online
        ]);

        return $store;
    }

    public function delete(int $id,Request $request){
        $user = $request->user();

        if (empty($store = Store::where('id', $id)->where('user_id', $user->id)->first())) {
            throw new Exception(__('store.delete.not_found'),404);
        }

        $store->delete();

        return null;
    }
}
