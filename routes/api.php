<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\MidtransCallbackController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
// Route::middleware('auth:sanctum')->post('/checkout', [OrderApiController::class, 'checkout']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/checkout', [OrderApiController::class, 'checkout']);
    Route::get('/orders', [OrderApiController::class, 'getUserOrders']);
    Route::get('/orders/{id}', [OrderApiController::class, 'getOrderDetail']);
});

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::get('/products', [ProductApiController::class, 'index']);
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'receiveCallback']);
Route::get('/payment-success', function () {
    return 'Payment success';
});

Route::get('/user/{id}', [UserApiController::class, 'show']);
