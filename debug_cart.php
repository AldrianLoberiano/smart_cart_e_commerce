<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "\n========================================\n";
echo "   SHOPPING CART DEBUG INFORMATION\n";
echo "========================================\n\n";

// 1. Database Connection
echo "1. DATABASE CONNECTION:\n";
try {
    DB::connection()->getPdo();
    echo "   ✓ Connected to database: " . DB::connection()->getDatabaseName() . "\n\n";
} catch (\Exception $e) {
    echo "   ✗ Database connection error: " . $e->getMessage() . "\n\n";
    exit(1);
}

// 2. Products Check
echo "2. PRODUCTS CHECK:\n";
$totalProducts = Product::count();
$activeProducts = Product::where('is_active', true)->count();
$inStockProducts = Product::where('is_active', true)->where('stock', '>', 0)->count();
echo "   Total Products: $totalProducts\n";
echo "   Active Products: $activeProducts\n";
echo "   In-Stock Products: $inStockProducts\n\n";

if ($inStockProducts === 0) {
    echo "   ⚠ WARNING: No products in stock! Run 'php artisan migrate:fresh --seed'\n\n";
}

// 3. Cart Items Check
echo "3. CART ITEMS CHECK:\n";
$totalCartItems = CartItem::count();
echo "   Total Cart Items (all): $totalCartItems\n";

$cartItemsByUser = CartItem::whereNotNull('user_id')
    ->selectRaw('user_id, COUNT(*) as count, SUM(quantity) as total_quantity')
    ->groupBy('user_id')
    ->get();

if ($cartItemsByUser->isNotEmpty()) {
    echo "   Cart Items by User:\n";
    foreach ($cartItemsByUser as $item) {
        echo "     - User ID {$item->user_id}: {$item->count} items ({$item->total_quantity} total quantity)\n";
    }
} else {
    echo "   No cart items for logged-in users\n";
}

$cartItemsBySession = CartItem::whereNotNull('session_id')
    ->selectRaw('session_id, COUNT(*) as count, SUM(quantity) as total_quantity')
    ->groupBy('session_id')
    ->get();

if ($cartItemsBySession->isNotEmpty()) {
    echo "   Cart Items by Session:\n";
    foreach ($cartItemsBySession as $item) {
        echo "     - Session {$item->session_id}: {$item->count} items ({$item->total_quantity} total quantity)\n";
    }
} else {
    echo "   No cart items for guest users\n";
}
echo "\n";

// 4. Orphaned Cart Items (products that don't exist)
echo "4. ORPHANED CART ITEMS CHECK:\n";
$orphanedItems = CartItem::whereDoesntHave('product')->count();
if ($orphanedItems > 0) {
    echo "   ⚠ WARNING: $orphanedItems orphaned cart items (products deleted)\n";
    echo "   Recommendation: Clean these up\n\n";
} else {
    echo "   ✓ No orphaned cart items\n\n";
}

// 5. Users Check
echo "5. USERS CHECK:\n";
$totalUsers = User::count();
echo "   Total Users: $totalUsers\n";
if ($totalUsers > 0) {
    $firstUser = User::first();
    echo "   First User: {$firstUser->name} (ID: {$firstUser->id}, Email: {$firstUser->email})\n";
} else {
    echo "   ⚠ No users in database\n";
}
echo "\n";

// 6. Recent Cart Activity
echo "6. RECENT CART ACTIVITY:\n";
$recentCartItems = CartItem::with('product:id,name,price')
    ->orderBy('updated_at', 'desc')
    ->limit(5)
    ->get();

if ($recentCartItems->isNotEmpty()) {
    echo "   Last 5 cart activities:\n";
    foreach ($recentCartItems as $item) {
        $userInfo = $item->user_id ? "User ID: {$item->user_id}" : "Session: " . substr($item->session_id, 0, 8) . "...";
        $productName = $item->product ? $item->product->name : "[DELETED PRODUCT]";
        echo "     - $userInfo | Product: $productName | Qty: {$item->quantity} | Updated: {$item->updated_at->diffForHumans()}\n";
    }
} else {
    echo "   No cart activity yet\n";
}
echo "\n";

// 7. API Routes Check
echo "7. API ROUTES CHECK:\n";
$routes = [
    '/api/cart' => 'GET - Get cart data',
    '/api/cart/add' => 'POST - Add item to cart',
    '/api/cart/update/{key}' => 'PUT - Update quantity',
    '/api/cart/remove/{key}' => 'DELETE - Remove item',
    '/api/cart/clear' => 'POST - Clear cart',
];

foreach ($routes as $route => $description) {
    echo "   $route - $description\n";
}
echo "\n";

// 8. Session Configuration
echo "8. SESSION CONFIGURATION:\n";
echo "   Driver: " . config('session.driver') . "\n";
echo "   Lifetime: " . config('session.lifetime') . " minutes\n";
echo "   Cookie Name: " . config('session.cookie') . "\n\n";

// 9. Recommendations
echo "9. RECOMMENDATIONS:\n";
if ($totalCartItems === 0) {
    echo "   📌 Cart is empty. To test:\n";
    echo "      - Visit: http://localhost:8000/test/add-to-cart (adds 3 test products)\n";
    echo "      - Or visit products page and click 'Add to Cart'\n";
}

if ($inStockProducts === 0) {
    echo "   📌 No products in stock. Run: php artisan migrate:fresh --seed\n";
}

if ($orphanedItems > 0) {
    echo "   📌 Clean orphaned items by accessing the cart (it auto-cleans)\n";
}

echo "\n========================================\n";
echo "   DEBUG COMPLETE\n";
echo "========================================\n\n";
