<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Contracts\StoreServiceInterface;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Contracts\StoreHelperInterface;

class StoreController extends Controller
{

    private $storeService;
    private $storeHelper;

    public function __construct(StoreServiceInterface $storeService, StoreHelperInterface $storeHelper)
    {
        $this->storeService = $storeService;
        $this->storeHelper = $storeHelper;
    }

    /**
     * Get all stores of current user
     * 
     * @OA\Get(
     *      path="/api/store",
     *      tags={"Store"},
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="page",
     *          description="Page",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="limit",
     *          description="Limit",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          description="name",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ), 
     *      @OA\Parameter(
     *          name="description",
     *          description="Description",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="address",
     *          description="Address",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="is_online",
     *          description="Is the store online?",
     *          in="query",
     *          @OA\Schema(
     *              type="boolean"
     *          )
     *      ),
     *      @OA\Response(
     *         response="200",
     *         description="Success",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Success"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         @OA\Items(
     *                             ref="#/components/schemas/StoreSchema",
     *                         )
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     *      @OA\Response(
     *         response="500",
     *         description="Server error",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Server error"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         example={}
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     * )
     * @param Request $request
     */
    public function index(Request $request): JsonResponse
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

    /**
     * Show detail of a store
     * 
     * @OA\Get(
     *      path="/api/store/{id}",
     *      tags={"Store"},
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="lang",
     *          description="Language (EN by default, or VN)",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Store id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *         response="200",
     *         description="Success",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Success"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         ref="#/components/schemas/StoreSchema"
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     *      @OA\Response(
     *         response="404",
     *         description="Not found",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Not found"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         example={}
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     *      @OA\Response(
     *         response="500",
     *         description="Server error",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Server error"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         example={}
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     * )
     * @param Request $request
     */
    public function show(int $id, Request $request)
    {
        $response = [
            'message' => __('store.show.success'),
            'data' => null
        ];

        $code = 200;

        try {
            DB::beginTransaction();

            $response['data'] = $this->storeService->show($id, $request);
        } catch (\Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $e->getCode();
        }

        DB::commit();

        return response()->json($response, $code);
    }

    /**
     * Add store
     * 
     * @OA\Post(
     *      path="/api/store",
     *      tags={"Store"},
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="lang",
     *          description="Language (EN by default, or VN)",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          description="Name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="description",
     *          description="Description",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="address",
     *          description="Address",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="is_online",
     *          description="Is the store online?",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="boolean"
     *          )
     *      ),
     *      @OA\Response(
     *         response="200",
     *         description="Success",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Success"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         ref="#/components/schemas/StoreSchema"
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     *      @OA\Response(
     *         response="422",
     *         description="Bad inputs",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Bad inputs"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         example={}
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     *      @OA\Response(
     *         response="500",
     *         description="Server error",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Server error"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         example={}
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     * )
     * @param Request $request
     */
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

    /**
     * Update store
     * 
     * @OA\Put(
     *      path="/api/store/{id}",
     *      tags={"Store"},
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="lang",
     *          description="Language (EN by default, or VN)",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Store id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          description="Name",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="description",
     *          description="Description",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="address",
     *          description="Address",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="is_online",
     *          description="Is the store online?",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="boolean"
     *          )
     *      ),
     *      @OA\Response(
     *         response="200",
     *         description="Success",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Success"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         ref="#/components/schemas/StoreSchema"
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     *      @OA\Response(
     *         response="404",
     *         description="Not found",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Not found"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         example={}
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     *      @OA\Response(
     *         response="422",
     *         description="Bad inputs",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Bad inputs"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         example={}
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     *      @OA\Response(
     *         response="500",
     *         description="Server error",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Server error"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         example={}
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     * )
     * @param Request $request
     */
    public function update(int $id, Request $request)
    {
        $response = [
            'message' => __('store.update.success'),
            'data' => null
        ];

        $code = 200;

        try {
            DB::beginTransaction();

            $this->storeHelper->validateUpdateRequest($request);

            $response['data'] = $this->storeService->update($id, $request);
        } catch (Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $e->getCode();
        }

        DB::commit();

        return response()->json($response, $code);
    }

    /**
     * Delete store
     * 
     * @OA\Delete(
     *      path="/api/store/{id}",
     *      tags={"Store"},
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="lang",
     *          description="Language (EN by default, or VN)",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="id",
     *          description="Store id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *         response="200",
     *         description="Success",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Success"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         example={}
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     *      @OA\Response(
     *         response="404",
     *         description="Not found",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Not found"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         example={}
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     *      @OA\Response(
     *         response="500",
     *         description="Server error",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Server error"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         example={}
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     * )
     * @param Request $request
     */
    public function delete(int $id, Request $request)
    {
        $response = [
            'message' => __('store.delete.success'),
            'data' => null
        ];

        $code = 200;

        try {
            DB::beginTransaction();

            $response['data'] = $this->storeService->delete($id, $request);
        } catch (Exception $e) {
            DB::rollBack();

            $response['message'] = $e->getMessage();

            $code = $e->getCode();
        }

        DB::commit();

        return response()->json($response, $code);
    }
}
