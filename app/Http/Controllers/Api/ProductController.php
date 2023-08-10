<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;

class ProductController extends Controller
{
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

        if (empty($product = Product::where('id', $id)->first()) || $product->getStoreOwnerId() != $user->id) {
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
}
