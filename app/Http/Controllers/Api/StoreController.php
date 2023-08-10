<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Validator;


class StoreController extends Controller
{
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
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error",
     *          @OA\JsonContent()
     *      )
     * )
     * @param Request $request
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $limitOfPagination = !empty($request->limit) ? $request->limit : 10;
        
        $stores = Store::where('user_id', $user->id);

        if(!empty($request->name)){
            $stores->where('name','like','%'.$request->name.'%');
        }

        if(!empty($request->description)){
            $stores->where('description','like','%'.$request->description.'%');
        }

        if(!empty($request->address)){
            $stores->where('address','like','%'.$request->address.'%');
        }

        if(!empty($request->is_online)){
            $stores->where('is_online',$request->is_online == "true" ? 1 : 0);
        }  

        $stores = $stores->paginate($limitOfPagination);

        return response()->json([
            'message' => "",
            'data' => [
                'data' => $stores
            ]
        ], 200);
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
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Bad credentials",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error",
     *          @OA\JsonContent()
     *      )
     * )
     * @param Request $request
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'is_online' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => __('validation.bad_credential'),
                'data' => [
                    'error' => $validator->errors(),
                ]
            ], 422);
        }

        $user = $request->user();

        $store = Store::create([
            'name' => $request->name,
            'user_id' => $user->id,
            'description' => $request->description ?? "",
            'address' => $request->address ?? "",
            'is_online' => $request->is_online
        ]);

        return response()->json([
            'message' => __('store.create.success'),
            'data' => [
                'store' => $store
            ]
        ], 200);
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
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Not found",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Bad credentials",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Error",
     *          @OA\JsonContent()
     *      )
     * )
     * @param Request $request
     */
    public function update(int $id, Request $request)
    {
        $user = $request->user();

        if (empty($store = Store::where('id', $id)->where('user_id', $user->id)->first())) {
            return response()->json([
                'message' => __('store.update.not_found'),
                'data' => []
            ], 404);
        }

        $store->update([
            'name' => $request->name ? $request->name : $store->name,
            'description' => $request->description ? $request->description : $store->description,
            'address' => $request->address ? $request->address : $store->address,
            'is_online' => $request->is_online == "true" ? 1 : 0
        ]);

        return response()->json([
            'message' => __('store.update.success'),
            'data' => [
                'store' => $store
            ]
        ], 200);
    }
}
