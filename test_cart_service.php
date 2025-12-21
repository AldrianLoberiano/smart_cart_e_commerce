<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

echo "\n========================================\n";
echo "   CART SERVICE TEST\n";
echo "========================================\n\n";

// Test 1: Guest Cart
echo "1. TESTING GUEST CART (no login):\n";
Session::start();
$sessionId = Session::getId();
echo "   Session ID: $sessionId\n";

$cartService = app(CartService::class);
$guestCart = $cartService->getCartData();
echo "   Guest Cart Items: " . count($guestCart['items']) . "\n";
echo "   Guest Cart Item Count: " . $guestCart['item_count'] . "\n";

if (count($guestCart['items']) > 0) {
    echo "   Guest Cart Contents:\n";
    foreach ($guestCart['items'] as $item) {
        echo "     - {$item['name']} x {$item['quantity']} = \${$item['price']}\n";
    }
}
echo "\n";

// Test 2: User Cart (login as first user)
echo "2. TESTING USER CART (logged in as User ID 1):\n";
$user = User::find(1);

if ($user) {
    Auth::login($user);
    echo "   Logged in as: {$user->name} ({$user->email})\n";
    echo "   User ID: {$user->id}\n";

    $userCart = $cartService->getCartData();
    echo "   User Cart Items: " . count($userCart['items']) . "\n";
    echo "   User Cart Item Count: " . $userCart['item_count'] . "\n";
    echo "   Subtotal: \$" . number_format($userCart['subtotal'], 2) . "\n";
    echo "   Tax: \$" . number_format($userCart['tax'], 2) . "\n";
    echo "   Total: \$" . number_format($userCart['total'], 2) . "\n";

    if (count($userCart['items']) > 0) {
        echo "\n   User Cart Contents:\n";
        foreach ($userCart['items'] as $item) {
            echo "     - {$item['name']} x {$item['quantity']} = \$" . number_format($item['price'] * $item['quantity'], 2) . "\n";
        }
    }
} else {
    echo "   ✗ No user found with ID 1\n";
}

echo "\n========================================\n";
echo "   TEST COMPLETE\n";
echo "========================================\n\n";

echo "SOLUTION TO VIEW CART:\n";
echo "  1. Login at: http://localhost:8000/login\n";
echo "     Email: {$user->email}\n";
echo "     Password: password\n\n";
echo "  2. Then visit: http://localhost:8000/cart\n\n";
