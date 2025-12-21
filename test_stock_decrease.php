<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use App\Models\User;
use App\Models\CartItem;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

echo "=== Testing Stock Decrease on Order ===\n\n";

// Get product
$product = Product::find(1);
echo "Product: {$product->name}\n";
echo "Initial Stock: {$product->stock}\n\n";

// Get or create user
$user = User::first();
if (!$user) {
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);
}

Auth::login($user);
echo "Logged in as: {$user->email}\n\n";

// Clear cart
CartItem::where('user_id', $user->id)->delete();
echo "Cleared cart\n";

// Add to cart
$cartService = app(CartService::class);
$cartService->addItem($product->id, 5);
echo "Added 5 items to cart\n";

// Check stock (should NOT decrease yet)
$product->refresh();
echo "Stock after adding to cart: {$product->stock} (should be same)\n\n";

// Create order
echo "Creating order...\n";
$orderService = app(OrderService::class);

try {
    $order = $orderService->createFromCart([
        'email' => $user->email,
        'first_name' => 'Test',
        'last_name' => 'User',
        'phone' => '1234567890',
        'address' => '123 Test St',
        'city' => 'Test City',
        'state' => 'TS',
        'zip_code' => '12345',
        'country' => 'US',
        'shipping_cost' => 10,
        'payment_method' => 'card',
    ]);
    
    echo "✓ Order created successfully! Order ID: {$order->id}\n\n";
    
    // Check stock (SHOULD decrease now)
    $product->refresh();
    echo "Stock after order: {$product->stock}\n";
    echo "Expected decrease: 5\n";
    
    if ($product->stock < 50) {
        echo "\n✓✓✓ SUCCESS! Stock decreased when order was placed!\n";
    } else {
        echo "\n✗✗✗ FAILED! Stock did NOT decrease!\n";
    }
    
} catch (\Exception $e) {
    echo "✗ Error creating order: {$e->getMessage()}\n";
    echo $e->getTraceAsString();
}
