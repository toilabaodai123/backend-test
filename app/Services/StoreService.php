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
        $user = $request->user();

        if (empty($store = Store::where('id', $id)->where('user_id', $user->id)->first())) {
            throw new Exception(__('store.show.not_found'), 404);
        }

        return $store;
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

        $store = Store::create([
            Store::COLUMN_NAME => $request->get(Store::COLUMN_NAME),
            Store::COLUMN_USER_ID => $user->getAttribute(User::COLUMN_ID),
            Store::COLUMN_DESCRIPTION => $request->get(Store::COLUMN_DESCRIPTION),
            Store::COLUMN_ADDRESS => $request->get(Store::COLUMN_ADDRESS),
            STORE::COLUMN_IS_ONLINE => (bool)$request->get(Store::COLUMN_IS_ONLINE)
        ]);

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

        if (empty($store = $this->storeRepository->findStoreWithStoreIdAndUserId($id, $user->getAttribute(User::COLUMN_ID)))) {
            throw new Exception(__('store.update.not_found'), 404);
        }

        $updateData = [
            Store::COLUMN_NAME => $request->get(Store::COLUMN_NAME) ? $request->get(Store::COLUMN_NAME) : $store->getAttribute(STORE::COLUMN_ID),
            Store::COLUMN_DESCRIPTION => $request->get(Store::COLUMN_DESCRIPTION) ? $request->get(Store::COLUMN_DESCRIPTION) : $store->getAttribute(Store::COLUMN_DESCRIPTION),
            STORE::COLUMN_ADDRESS => $request->get(Store::COLUMN_ADDRESS) ? $request->get(Store::COLUMN_ADDRESS) : $store->getAttribute(Store::COLUMN_ADDRESS),
            STORE::COLUMN_IS_ONLINE => (bool)$request->get(Store::COLUMN_IS_ONLINE)
        ];

        $store = $this->storeRepository->update($store->getAttribute(Store::COLUMN_ID), $updateData);

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

        if (empty($store = $this->storeRepository->findStoreWithStoreIdAndUserId($id, $user->getAttribute(User::COLUMN_ID)))) {
            throw new Exception(__('store.delete.not_found'), 404);
        }

        $store = $this->storeRepository->delete($id);

        $response = $store;

        return $response;
    }
}
