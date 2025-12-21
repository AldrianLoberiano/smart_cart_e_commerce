<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

$productId = $argv[1] ?? 1;
$decreaseBy = $argv[2] ?? 5;

$product = Product::find($productId);

if (!$product) {
    echo "Product not found!\n";
    exit(1);
}

echo "Product: {$product->name}\n";
echo "Current Stock: {$product->stock}\n";
echo "Decreasing by: {$decreaseBy}\n\n";

$product->decrementStock($decreaseBy);

$product->refresh();
echo "New Stock: {$product->stock}\n";
echo "\nNow check your browser - the stock should update within 5 seconds!\n";
