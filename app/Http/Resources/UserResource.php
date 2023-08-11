<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{


    /**
     * @OA\Schema(
     *    schema="UserSchema",
     *        @OA\Property(
     *            property="name",
     *            description="User name",
     *            type="string",
     *            nullable="false",
     *            example="Kellen Boyer"
     *        ),
     *        @OA\Property(
     *            property="email",
     *            description="User E-mail",
     *            type="string",
     *            nullable="false",
     *            example="kellen.boyer@example.com"
     *        ),
     *    )
     * )
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
