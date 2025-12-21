<?php
// Quick cart status checker
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');

$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

use App\Models\CartItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Cart Status Check</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }

        .info-box {
            background: white;
            padding: 20px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .success {
            color: #22c55e;
            font-weight: bold;
        }

        .error {
            color: #ef4444;
            font-weight: bold;
        }

        .warning {
            color: #f59e0b;
            font-weight: bold;
        }

        h1 {
            color: #1f2937;
        }

        h2 {
            color: #374151;
            margin-top: 0;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 5px;
        }

        .button:hover {
            background: #2563eb;
        }
    </style>
</head>

<body>
    <h1>🛒 SmartCart Status Check</h1>

    <div class="info-box">
        <h2>Authentication Status</h2>
        <?php if (Auth::check()): ?>
            <p class="success">✓ LOGGED IN</p>
            <p><strong>User:</strong> <?= Auth::user()->name ?> (<?= Auth::user()->email ?>)</p>
            <p><strong>User ID:</strong> <?= Auth::id() ?></p>
        <?php else: ?>
            <p class="error">✗ NOT LOGGED IN (Guest)</p>
            <p><strong>Session ID:</strong> <?= Session::getId() ?></p>
        <?php endif; ?>
    </div>

    <div class="info-box">
        <h2>Cart Status</h2>
        <?php
        $cartService = app(\App\Services\CartService::class);
        $cartData = $cartService->getCartData();
        $itemCount = count($cartData['items']);
        ?>

        <?php if ($itemCount > 0): ?>
            <p class="success">✓ Cart has <?= $itemCount ?> item(s)</p>
            <p><strong>Total Quantity:</strong> <?= $cartData['item_count'] ?></p>
            <p><strong>Subtotal:</strong> $<?= number_format($cartData['subtotal'], 2) ?></p>
            <p><strong>Tax:</strong> $<?= number_format($cartData['tax'], 2) ?></p>
            <p><strong>Total:</strong> $<?= number_format($cartData['total'], 2) ?></p>

            <h3>Cart Items:</h3>
            <ul>
                <?php foreach ($cartData['items'] as $item): ?>
                    <li><?= htmlspecialchars($item['name']) ?> x <?= $item['quantity'] ?> = $<?= number_format($item['price'] * $item['quantity'], 2) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="warning">⚠ Cart is empty</p>
        <?php endif; ?>
    </div>

    <div class="info-box">
        <h2>Database Cart Items</h2>
        <?php
        $totalCartItems = CartItem::count();
        $userCartItems = Auth::check() ? CartItem::where('user_id', Auth::id())->count() : 0;
        $sessionCartItems = !Auth::check() ? CartItem::where('session_id', Session::getId())->count() : 0;
        ?>
        <p><strong>Total Cart Items (all users):</strong> <?= $totalCartItems ?></p>
        <?php if (Auth::check()): ?>
            <p><strong>Your Cart Items (database):</strong> <?= $userCartItems ?></p>
        <?php else: ?>
            <p><strong>Your Session Cart Items (database):</strong> <?= $sessionCartItems ?></p>
        <?php endif; ?>
    </div>

    <div class="info-box">
        <h2>Actions</h2>
        <?php if (!Auth::check()): ?>
            <a href="/login" class="button">🔐 Login</a>
            <p style="margin-top: 10px;"><small>Login credentials: <br>Email: <code>JohnDoe@gmail.com</code> | Password: <code>password</code></small></p>
        <?php else: ?>
            <a href="/logout" class="button">🚪 Logout</a>
        <?php endif; ?>
        <a href="/cart" class="button">🛒 View Cart</a>
        <a href="/products" class="button">🛍️ Shop Products</a>
        <a href="/test/add-to-cart" class="button">➕ Add Test Items</a>
    </div>

    <p style="text-align: center; margin-top: 30px;">
        <a href="/" style="color: #6b7280; text-decoration: none;">← Back to Home</a>
    </p>
</body>

</html>