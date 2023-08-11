<?php

namespace App\Services;


use Illuminate\Http\Request;
use App\Models\Store;
use Exception;
use App\Contracts\StoreRepositoryInterface;

class StoreService implements \App\Contracts\StoreServiceInterface
{
    private $storeRepository;

    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;   
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $stores = $this->storeRepository->searchStore($user->id,$request);

        return $stores;
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
