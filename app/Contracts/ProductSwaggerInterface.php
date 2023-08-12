<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface ProductSwaggerInterface
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
     *                         type="array",
     *                         @OA\Items(
     *                             ref="#/components/schemas/ProductSchema",
     *                         )
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
     *      ),
     * )
     * @param Request $request
     */
    public function index(Request $request);
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
     *                         ref="#/components/schemas/ProductSchema"
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     *      @OA\Response(
     *         response="404",
     *         description="Not found",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Not found"
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
    public function show(int $id, Request $request);
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
     *                         ref="#/components/schemas/ProductSchema"
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
     *                         ref="#/components/schemas/ProductSchema"
     *                     )
     *                 )
     *             )
     *         }
     *      ),
     *      @OA\Response(
     *         response="404",
     *         description="Not found",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Not found"
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
    public function update(int $id, Request $request);
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
     *         response="404",
     *         description="Not found",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message",
     *                         example="Not found"
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
    public function delete(int $id, Request $request);
}
