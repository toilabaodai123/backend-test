<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Support\Facades\Validator;
use App\Contracts\ProductSwaggerInterface;
use App\Contracts\ProductServiceInterface;
use App\Contracts\ProductHelperInterface;
use App\Traits\CheckErrorCode;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductController extends Controller implements ProductSwaggerInterface
{
    use CheckErrorCode;

    private $productService;
    private $productHelper;

    public function __construct(ProductServiceInterface $productService, ProductHelperInterface $productHelper)
    {
        $this->productService = $productService;
        $this->productHelper = $productHelper;
    }

    public function index(Request $request)
    {
        $response = [
            'message' => __('product.show.success'),
            'data' => [],
        ];

        $code = 200;

        try {
            $response['data'] = $this->productService->index($request);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();

            $code = $this->checkErrorCode($e->getCode());
        }

        return response()->json($response, $code);
    }

    public function show(int $id, Request $request)
    {
        $response = [
            'message' => __('product.show.success'),
            'data' => [],
        ];

        $code = 200;

        try {
            $response['data'] = $this->productService->show($id, $request);
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();

            $code = $this->checkErrorCode($e->getCode());
        }

        return response()->json($response, $code);
    }

    public function store(Request $request)
    {
        $response = [
            'message' => __('product.create.success'),
            'data' => [],
        ];

        $code = 200;

        try {
            $this->productHelper->validateStoreRequest($request);

            DB::beginTransaction();

            $response['data'] = $this->productService->store($request);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $this->checkErrorCode($e->getCode());
        }

        return response()->json($response, $code);
    }

    public function update(int $id, Request $request)
    {
        $response = [
            'message' => __('product.update.success'),
            'data' => [],
        ];

        $code = 200;

        try {
            DB::beginTransaction();

            $response['data'] = $this->productService->update($id,$request);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $this->checkErrorCode($e->getCode());
        }

        return response()->json($response, $code);
    }

    public function delete(int $id, Request $request)
    {
        $response = [
            'message' => __('product.delete.success'),
            'data' => [],
        ];

        $code = 200;

        try {
            DB::beginTransaction();

            $response['data'] = $this->productService->delete($id,$request);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $this->checkErrorCode($e->getCode());
        }

        return response()->json($response, $code);
    }
}
