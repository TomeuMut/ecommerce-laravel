<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Product;

/**
 * @OA\Info(
 *     title="Ecommerce Laravel API",
 *     version="1.0.0",
 *     description="API Docs for Ecommerce Laravel"
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="LocalHost"
 * )
 */

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/products",
     *     summary="List products",
     *     description="Get all products in db",
     *     @OA\Response(
     *         response=200,
     *         description="List products",
     *     )
     * )
     */
    public function index()
    {
        $products = Cache::remember('products_list', 3600, function () {
            return Product::with('category')->get();
        });

        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/products",
     *     summary="Create a product",
     *     description="Create a new product with validate fields",
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product create successfully",
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|string',
        ]);

        $product =Product::create($validated);

        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
 * @OA\Put(
 *     path="/products/{id}",
 *     summary="Update a product",
 *     description="Update an existing product in the database",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="Update product with id of product to update",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="name", type="string", nullable=true),
 *             @OA\Property(property="description", type="string", nullable=true),
 *             @OA\Property(property="price", type="number", format="float", nullable=true),
 *             @OA\Property(property="stock", type="integer", nullable=true),
 *             @OA\Property(property="category_id", type="integer", nullable=true),
 *             @OA\Property(property="image", type="string", nullable=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Product updated successfully",
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Product not found"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     )
 * )
 */
    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);

        $product->update($validated);

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Delete(
     *     path="/products/{id}",
     *     summary="Delete a product",
     *     description="Remove a product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the product to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product removed successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Product removed successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json(['message' => 'Product removed successfully.'], 200);

    }
    /**
     * @OA\Get(
     *     path="/products/random",
     *     summary="Get a random product",
     *     description="Retrieve a random product",
     *     @OA\Response(
     *         response=200,
     *         description="Random product retrieved successfully",
     *     )
     * )
     */
    public function random()
    {

        $product = Cache::remember('random_product', 600, function () {
            return Product::inRandomOrder()->first();
        });

        return response()->json($product);

    }
}
