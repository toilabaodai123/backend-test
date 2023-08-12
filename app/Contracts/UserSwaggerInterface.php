<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface UserSwaggerInterface
{
    /**
     * Register User
     * 
     * @OA\Post(
     *      path="/api/user/register",
     *      tags={"User"},
     *      @OA\Parameter(
     *          name="lang",
     *          description="Language (EN by default, or VN)",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          description="Email",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              format="password"
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
     *                         example={
     *                              "token" : "abc"
     *                         }
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
    public function store(Request $request);
}
