<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
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
    Route::get('/login', function () {
        return View::make('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return View::make('auth.register');
    })->name('register');
});

Route::middleware('auth')->post('/logout', function () {
    Auth::logout();
    Request::session()->invalidate();
    Request::session()->regenerateToken();
    return Redirect::to('/');
})->name('logout');

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

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

// Guest checkout (optional)
Route::get('/checkout/guest', [CheckoutController::class, 'index'])->name('checkout.guest');
