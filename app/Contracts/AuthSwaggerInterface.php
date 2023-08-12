<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface AuthSwaggerInterface
{
    /**
     * Login User
     * 
     * @OA\Post(
     *      path="/api/auth/login",
     *      tags={"Auth"},
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
     *         response="401",
     *         description="Wrong credentials",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Wrong credentials"
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
    public function login(Request $request);
    /**
     * Logout User
     * 
     * @OA\Post(
     *      path="/api/auth/logout",
     *      tags={"Auth"},
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="lang",
     *          description="Language (EN by default, or VN)",
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
     *                         example={}
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     *      @OA\Response(
     *         response="401",
     *         description="Wrong credentials",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Wrong credentials"
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
     *      )
     * )
     * @param Request $request
     */
    public function logout(Request $request);
}
