<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use App\Contracts\StoreServiceInterface;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Contracts\StoreHelperInterface;
use App\Contracts\StoreSwaggerInterface;
use App\Traits\CheckErrorCode;

class StoreController extends Controller implements StoreSwaggerInterface
{
    use CheckErrorCode;

    private $storeService;
    private $storeHelper;

    public function __construct(StoreServiceInterface $storeService, StoreHelperInterface $storeHelper)
    {
        $this->storeService = $storeService;
        $this->storeHelper = $storeHelper;
    }

    public function index(Request $request)
    {
        $response = [
            'message' => __('store.show.success'),
            'data' => [],
        ];

        $code = 200;

        try {
            $response['data'] = $this->storeService->index($request);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();

            $code = $this->checkErrorCode($e->getCode());
        }

        return response()->json($response, $code);
    }

    public function show(int $store_id, Request $request)
    {
        $response = [
            'message' => __('store.show.success'),
            'data' => null
        ];

        $code = 200;

        try {
            DB::beginTransaction();

            $response['data'] = $this->storeService->show($store_id, $request);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $this->checkErrorCode($e->getCode());
        }

        return response()->json($response, $code);
    }

    public function store(Request $request)
    {
        $response = [
            'message' => __('store.create.success'),
            'data' => null
        ];

        $code = 200;

        try {
            $this->storeHelper->validateStoreRequest($request);

            DB::beginTransaction();

            $response['data'] = $this->storeService->store($request);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $this->checkErrorCode($e->getCode());
        }

        return response()->json($response, $code);
    }

    public function update(int $store_id, Request $request)
    {
        $response = [
            'message' => __('store.update.success'),
            'data' => null
        ];

        $code = 200;

        try {
            $this->storeHelper->validateUpdateRequest($request);

            DB::beginTransaction();

            $response['data'] = $this->storeService->update($store_id, $request);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $this->checkErrorCode($e->getCode());
        }

        return response()->json($response, $code);
    }

    public function delete(int $store_id, Request $request)
    {
        $response = [
            'message' => __('store.delete.success'),
            'data' => null
        ];

        $code = 200;

        try {
            DB::beginTransaction();

            $response['data'] = $this->storeService->delete($store_id, $request);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $this->checkErrorCode($e->getCode());
        }

        return response()->json($response, $code);
    }
}
