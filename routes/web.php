<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->post('/logout', [LoginController::class, 'logout'])->name('logout');

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Cart
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{itemKey}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{itemKey}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// Orders
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/orders/{order}/confirmation', [OrderController::class, 'confirmation'])->name('orders.confirmation');
Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

// Reviews (must be authenticated)
Route::middleware('auth')->group(function () {
    Route::post('/products/{product}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Guest checkout (optional)
Route::get('/checkout/guest', [CheckoutController::class, 'index'])->name('checkout.guest');

// Test route to quickly add items to cart (for development only)
if (config('app.debug')) {
    Route::get('/test/add-to-cart', function () {
        $cartService = app(\App\Services\CartService::class);
        
        // Get first 3 active products
        $products = \App\Models\Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->limit(3)
            ->get();
        
        if ($products->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'No products available to add to cart. Please seed the database first.');
        }
        
        foreach ($products as $product) {
            try {
                $cartService->addItem($product->id, 1);
            } catch (\Exception $e) {
                // Skip if error
            }
        }
        
        return redirect()->route('cart.index')
            ->with('success', 'Added ' . $products->count() . ' products to your cart for testing!');
    })->name('test.cart');
}
