<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * @OA\Schema(
     *    schema="StoreSchema",
     *        @OA\Property(
     *            property="user",
     *            description="User",
     *            ref="#/components/schemas/UserSchema"
     *        ),
     *        @OA\Property(
     *            property="name",
     *            description="Store name",
     *            type="string",
     *            nullable="false",
     *            example="Store name A"
     *        ),
     *        @OA\Property(
     *            property="Description",
     *            description="Description",
     *            type="string",
     *            nullable="false",
     *            example="Description A"
     *        ),
     *        @OA\Property(
     *            property="Address",
     *            description="Address",
     *            type="string",
     *            nullable="false",
     *            example="Address A"
     *        ),
     *        @OA\Property(
     *            property="is_online",
     *            description="Is online?",
     *            type="boolean",
     *            nullable="false",
     *            example=true
     *        ),
     *    )
     * )
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
