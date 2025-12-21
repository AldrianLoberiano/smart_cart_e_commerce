<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Cart endpoints
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'store']);
    Route::patch('/cart/items/{itemKey}', [CartController::class, 'update']);
    Route::delete('/cart/items/{itemKey}', [CartController::class, 'destroy']);
    Route::delete('/cart', [CartController::class, 'clear']);

    // Product endpoints
    Route::get('/products/search', [ProductController::class, 'search']);
    Route::get('/product-stock/{id}', [ProductController::class, 'stock']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
});

// Legacy API routes (without version prefix)
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add', [CartController::class, 'store']);
Route::patch('/cart/items/{itemKey}', [CartController::class, 'update']);
Route::delete('/cart/items/{itemKey}', [CartController::class, 'destroy']);
Route::delete('/cart', [CartController::class, 'clear']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/product-stock/{id}', [ProductController::class, 'stock']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process']);
