<?php

namespace App\Services;

use App\Contracts\ProductServiceInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\StoreRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Product;
use Exception;

class ProductService implements ProductServiceInterface
{
    private $productRepository;
    private $storeRepository;

    public function __construct(ProductRepositoryInterface $productRepository, StoreRepositoryInterface $storeRepository)
    {
        $this->productRepository = $productRepository;
        $this->storeRepository = $storeRepository;
    }

    public function index(Request $request)
    {
        $result = null;

        $user = $request->user();

        $products = $this->productRepository->searchProduct($user->id, $request);

        $result = $products;

        return $result;
    }

    public function show(int $id, Request $request)
    {
        $result = null;

        $user = $request->user();

        $product = $this->productRepository->find($id);

        if (empty($product) || $product->store->user_id != $user->id) {
            throw new Exception(__('product.show.not_found'), 404);
        }

        $result = $product;

        return $result;
    }
    public function store(Request $request)
    {
        $response = null;

        $user = $request->user();

        $store = $this->storeRepository->find($request->store_id);

        if (!empty($store) && $store->user_id != $user->id) {
            throw new Exception(__('validation.bad_credential'), 422);
        }

        $productStore = [
            'name' => $request->get('name'),
            'store_id' => $request->get('store_id'),
            'description' => $request->get('description'),
            'stock' => $request->get('stock'),
            'price' => $request->get('price')
        ];

        $product = $this->productRepository->create($productStore);

        $response = $product;

        return $response;
    }
    public function update(int $id, Request $request)
    {
        $response = null;

        $user = $request->user();

        $product = $this->productRepository->find($id);

        if (empty($product) || $product->store->user_id != $user->id) {
            throw new Exception(__('product.update.not_found'), 404);
        }

        $productUpdate = [
            'name' => $request->name ? $request->name : $product->name,
            'description' => $request->description ? $request->description : $product->description,
            'stock' => $request->stock ? (int)$request->stock : $product->stock,
            'price' => $request->price ? (int)$request->price : $product->price,
        ];

        $product = $this->productRepository->update($id, $productUpdate);

        $response = $product;

        return $response;
    }
    public function delete(int $id, Request $request)
    {
        $response = null;

        $user = $request->user();

        $product = $this->productRepository->find($id);

        if (empty($product) || $product->store->user_id != $user->id) {
            throw new Exception(__('product.delete.not_found'),404);
        }

        $product = $this->productRepository->delete($id);

        $response = $product;

        return $response;
    }
}
