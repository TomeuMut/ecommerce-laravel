<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/orders",
     *     summary="List orders",
     *     description="Retrieve all orders",
     *     @OA\Response(
     *         response=200,
     *         description="List of orders",
     *     )
     * )
     */
    public function index()
    {

        $order = Order::all();

        return $order;

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
     *     path="/orders",
     *     summary="Create a order",
     *     description="Store a order with items",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"user_id", "items"},
     *             @OA\Property(property="user_id", type="integer", example=1, description="ID of the user placing the order"),
     *             @OA\Property(
     *                 property="items",
     *                 type="array",
     *                 description="List of items in the order",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"product_id", "quantity"},
     *                     @OA\Property(property="product_id", type="integer", example=2, description="ID of the product"),
     *                     @OA\Property(property="quantity", type="integer", example=3, description="Quantity of the product")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Order created successfully",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

           $order = Order::create([
            'user_id' => $validated['user_id'],
            'total_amount' => 0,
            'status' => 'pending',
        ]);

        $totalAmount = 0;

        foreach ($validated['items'] as $item) {

            $product = Product::findOrFail($item['product_id']);
            $price = $product->price * $item['quantity'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $price,
            ]);

            $totalAmount += $price;
        }

        $order->update(['total_amount' => $totalAmount]);

        return $order;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Get(
     *     path="/orders/{id}",
     *     summary="Get a specific order",
     *     description="Retrieve details of a specific order by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the order",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order details",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     )
     * )
     */

    public function show(Order $order)
    {
        return $order->load('items');
    }


    /**
     * @OA\Put(
     *     path="/orders/{id}/cancel",
     *     summary="Cancel an order",
     *     description="Change the status of an order to 'canceled'",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the order to cancel",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order canceled successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Order Canceled")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     )
     * )
     */
    public function cancel(Order $order)
    {
        $order->update(['status' => 'canceled']);
        return response()->json(['message' => 'Order Canceled'], 200);
    }

    /**
     * @OA\Get(
     *     path="/orders/{id}/status",
     *     summary="Get the status of an order",
     *     description="Retrieve the current status of a specific order",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the order",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order status retrieved",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="pending")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     )
     * )
     */

    public function status(Order $order)
    {
        return response()->json(['status' => $order->status]);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
