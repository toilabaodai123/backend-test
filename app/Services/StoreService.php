<?php

namespace App\Services;


use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\User;
use Exception;
use App\Contracts\StoreRepositoryInterface;

/**
 * StoreService
 */
class StoreService implements \App\Contracts\StoreServiceInterface
{
    /**
     * storeRepository
     *
     * @var mixed
     */
    private $storeRepository;

    /**
     * __construct
     *
     * @param  mixed $storeRepository
     * @return void
     */
    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        $response = null;

        $user = $request->user();

        $stores = $this->storeRepository->searchStore($user->id, $request);

        $response = $stores;

        return $response;
    }

    /**
     * show
     *
     * @param  mixed $id
     * @param  mixed $request
     * @return void
     */
    public function show(int $id, Request $request)
    {
        $response = null;

        $user = $request->user();

        if (empty($store = $this->storeRepository->findStoreWithStoreIdAndUserId($id, $user->getAttribute('id')))) {
            throw new Exception(__('store.show.not_found'), 404);
        }

        $response = $store;

        return $response;
    }   

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {   
        $response = null;

        $user = $request->user();

        $storeData = [
            'name' => $request->get('name'),
            'user_id' => $user->getAttribute('id'),
            'description' => $request->get('description'),
            'address' => $request->get('address'),
            'is_online' => (bool)$request->get('is_online')
        ];

        $store = $this->storeRepository->create($storeData);

        $response = $store;

        return $response;
    }

    /**
     * update
     *
     * @param  mixed $id
     * @param  mixed $request
     * @return void
     */
    public function update(int $id, Request $request)
    {
        $response = null;

        $user = $request->user();

        if (empty($store = $this->storeRepository->findStoreWithStoreIdAndUserId($id, $user->getAttribute('id')))) {
            throw new Exception(__('store.update.not_found'), 404);
        }

        $updateData = [
            'name' => $request->get('name') ?? $store->getAttribute('name'),
            'description' => $request->get('description') ?? $store->getAttribute('description'),
            'address' => $request->get('address') ?? $store->getAttribute('address'),
            'is_online' => (bool)$request->get('is_online')
        ];

        $store = $this->storeRepository->update($store->getAttribute('id'), $updateData);

        $response = $store;

        return $response;
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @param  mixed $request
     * @return void
     */
    public function delete(int $id, Request $request)
    {
        $response = null;

        $user = $request->user();

        if (empty($store = $this->storeRepository->findStoreWithStoreIdAndUserId($id, $user->getAttribute('id')))) {
            throw new Exception(__('store.delete.not_found'), 404);
        }

        $store = $this->storeRepository->delete($id);

        $response = $store;

        return $response;
    }
}
