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

class StoreController extends Controller implements StoreSwaggerInterface
{

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
            DB::beginTransaction();

            $response['data'] = $this->storeService->index($request);
        } catch (Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $e->getCode();
        }

        DB::commit();

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
        } catch (\Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $e->getCode();
        }

        DB::commit();

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
            DB::beginTransaction();

            $this->storeHelper->validateStoreRequest($request);

            $response['data'] = $this->storeService->store($request);
        } catch (Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $e->getCode();
        }

        DB::commit();

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
            DB::beginTransaction();

            $this->storeHelper->validateUpdateRequest($request);

            $response['data'] = $this->storeService->update($store_id, $request);
        } catch (Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $e->getCode();
        }

        DB::commit();

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
        } catch (Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $e->getCode();
        }

        DB::commit();

        return response()->json($response, $code);
    }
}
