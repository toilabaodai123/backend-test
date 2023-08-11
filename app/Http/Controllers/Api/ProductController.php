<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    /**
     * Get all products of current user
     * 
     * @OA\Get(
     *      path="/api/product",
     *      tags={"Product"},
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="page",
     *          description="page",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="limit",
     *          description="limit",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="store_id",
     *          description="Store id",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
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
     *          name="stock",
     *          description="stock",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="price",
     *          description="price",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
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

        if (!empty($request->store_id)) {
            $stores->where('id', $request->store_id);
        }

        $stores = $stores->get()->pluck('id')->toArray();

        $products = Product::whereIn('store_id', $stores);

        if (!empty($request->name)) {
            $products->where('name', 'like', '%' . $request->name . '%');
        }

        if (!empty($request->description)) {
            $products->where('description', 'like', '%' . $request->description . '%');
        }

        if (!empty($request->stock)) {
            $products->where('stock', $request->stock);
        }

        if (!empty($request->price)) {
            $products->where('price', $request->price);
        }

        $products = $products->paginate($limitOfPagination);

        return response()->json([
            'message' => "",
            'data' => [
                'data' => $products
            ]
        ], 200);
    }

    /**
     * Show detail of a product
     * 
     * @OA\Get(
     *      path="/api/product/{id}",
     *      tags={"Product"},
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
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
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
     *          response=500,
     *          description="Error",
     *          @OA\JsonContent()
     *      )
     * )
     * @param Request $request
     */
    public function show(int $id, Request $request)
    {
        $user = $request->user();

        $product = Product::find($id);

        if (empty($product) || $product->store->user_id != $user->id) {
            return response()->json([
                'message' => __('product.show.not_found'),
                'data' => []
            ], 404);
        }

        return response()->json([
            'message' => __('product.show.success'),
            'data' => $product
        ], 200);
    }

    /**
     * Add Product
     * 
     * @OA\Post(
     *      path="/api/product",
     *      tags={"Product"},
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
     *          name="stock",
     *          description="Stock",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="price",
     *          description="Price",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="store_id",
     *          description="Store id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
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
            'description' => 'required',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'store_id' => 'required|exists:stores,id'
        ]);

        $user = $request->user();

        if ($validator->fails() || Store::find($request->store_id)->user_id != $user->id) {
            return response()->json([
                'message' => __('validation.bad_credential'),
                'data' => [
                    'error' => $validator->errors(),
                ]
            ], 422);
        }

        $product = Product::create([
            'name' => $request->name,
            'store_id' => $request->store_id,
            'description' => $request->description,
            'stock' => $request->stock,
            'price' => $request->price
        ]);

        return response()->json([
            'message' => __('product.create.success'),
            'data' => [
                'store' => $product
            ]
        ], 200);
    }

    /**
     * Update product
     * 
     * @OA\Put(
     *      path="/api/product/{id}",
     *      tags={"Product"},
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
     *          description="Product id",
     *          required=true,
     *          in="path",
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
     *          description="description",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="stock",
     *          description="stock",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="price",
     *          description="price",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
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

        $product = Product::find($id);

        if (empty($product) || $product->store->user_id != $user->id) {
            return response()->json([
                'message' => __('product.update.not_found'),
                'data' => []
            ], 404);
        }

        $product->update([
            'name' => !empty($request->name) ? $request->name : $product->name,
            'description' => !empty($request->description) ? $request->description : $product->description,
            'stock' => !empty($request->stock) ? (int)$request->stock : $product->stock,
            'price' => !empty($request->price) ? (int)$request->price : $product->price,
        ]);

        return response()->json([
            'message' => __('product.update.success'),
            'data' => $product
        ], 200);
    }

    /**
     * Delete product
     * 
     * @OA\Delete(
     *      path="/api/product/{id}",
     *      tags={"Product"},
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
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
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
     *          response=500,
     *          description="Error",
     *          @OA\JsonContent()
     *      )
     * )
     * @param Request $request
     */
    public function delete(int $id, Request $request)
    {
        $user = $request->user();

        $product = Product::find($id);

        if (empty($product) || $product->store->user_id != $user->id) {
            return response()->json([
                'message' => __('product.delete.not_found'),
                'data' => []
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => __('product.delete.success'),
            'data' => $product
        ], 200);
    }    
}
