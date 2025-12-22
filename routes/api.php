<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StockController;
use App\Models\Product;
use Illuminate\Http\Request;
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

// Real-time stock monitoring
Route::post('/stock/check', [StockController::class, 'check']);
Route::get('/stock/{product}', [StockController::class, 'show']);

// Test endpoint to simulate purchases (development only)
if (config('app.debug')) {
    Route::post('/test/simulate-purchase', function (Request $request) {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($validated['product_id']);

        if (!$product->track_stock) {
            return response()->json([
                'success' => false,
                'message' => 'Product does not track stock'
            ]);
        }

        if ($product->stock < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock'
            ]);
        }

        $product->decrementStock($validated['quantity']);
        $product->refresh();

        return response()->json([
            'success' => true,
            'new_stock' => $product->stock,
            'message' => "Decreased stock by {$validated['quantity']}"
        ]);
    });
}

// Test endpoint for simulating purchases
Route::post('/test/simulate-purchase', function (Request $request) {
    $validated = $request->validate([
        'product_id' => 'required|integer|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $product = Product::find($validated['product_id']);

    if ($product->decrementStock($validated['quantity'])) {
        return response()->json([
            'success' => true,
            'new_stock' => $product->fresh()->stock,
            'message' => 'Stock decreased successfully',
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Insufficient stock',
    ], 400);
});
