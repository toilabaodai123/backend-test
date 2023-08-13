<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Contracts\ProductRepositoryInterface;
use App\Models\Store;
use App\Models\Product;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $product)
    {
        $this->setModel($product);
    }

    public function searchProduct(int $user_id, Request $request)
    {
        $limitOfPagination = !empty($request->limit) ? $request->limit : 10;

        $stores = Store::where('user_id', $user_id);

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

        return $products->paginate($limitOfPagination);
    }
}
