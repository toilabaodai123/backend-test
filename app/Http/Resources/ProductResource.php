<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    /**
     * @OA\Schema(
     *    schema="ProductSchema",
     *        @OA\Property(
     *            property="store",
     *            description="Store",
     *            ref="#/components/schemas/StoreSchema"
     *        ),
     *        @OA\Property(
     *            property="name",
     *            description="Product name",
     *            type="string",
     *            nullable="false",
     *            example="Product name A"
     *        ),
     *        @OA\Property(
     *            property="description",
     *            description="Description",
     *            type="string",
     *            nullable="false",
     *            example="Description A"
     *        ),
     *        @OA\Property(
     *            property="stock",
     *            description="Stock",
     *            type="integer",
     *            nullable="false",
     *            example=1234
     *        ),
     *        @OA\Property(
     *            property="price",
     *            description="price",
     *            type="integer",
     *            nullable="false",
     *            example=123444
     *        ),
     *    )
     * )
     */

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
