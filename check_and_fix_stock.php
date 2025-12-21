<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\CartItem;

$productId = 1;
$product = Product::find($productId);

echo "=== Stock Status ===\n";
echo "Product: {$product->name}\n";
echo "Current Stock: {$product->stock}\n\n";

$cartItems = CartItem::where('product_id', $productId)->get();
echo "Items in carts: {$cartItems->sum('quantity')}\n";
echo "Available to sell: " . ($product->stock - $cartItems->sum('quantity')) . "\n\n";

if ($cartItems->count() > 0) {
    echo "Cart Details:\n";
    foreach ($cartItems as $item) {
        echo "  - User/Session: " . ($item->user_id ?? $item->session_id) . " | Quantity: {$item->quantity}\n";
    }
}

echo "\n=== Fixing Stock ===\n";
echo "Resetting stock to 50...\n";
$product->update(['stock' => 50]);
echo "New stock: {$product->stock}\n";
echo "\nYou can now add items to cart!\n";
