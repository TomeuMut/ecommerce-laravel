<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\OrdersController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('products', ProductsController::class);

Route::apiResource('categories', CategoriesController::class);

Route::get('products/random', [ProductsController::class, 'random']);

Route::post('orders', [OrdersController::class, 'store']);

Route::get('orders/{order}', [OrdersController::class, 'show']);

Route::put('orders/{order}/cancel', [OrdersController::class, 'cancel']);

Route::get('orders/{order}/status', [OrdersController::class, 'status']);

Route::get('user/orders', [OrdersController::class, 'userOrders'])->middleware('auth');
