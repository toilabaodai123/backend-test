<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Support\Facades\Validator;
use App\Contracts\ProductSwaggerInterface;
use App\Traits\CheckErrorCode;

class ProductController extends Controller implements ProductSwaggerInterface
{
    use CheckErrorCode;
    
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
            'name' => $request->name ? $request->name : $product->name,
            'description' => $request->description ? $request->description : $product->description,
            'stock' => $request->stock ? (int)$request->stock : $product->stock,
            'price' => $request->price ? (int)$request->price : $product->price,
        ]);

        return response()->json([
            'message' => __('product.update.success'),
            'data' => $product
        ], 200);
    }

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
