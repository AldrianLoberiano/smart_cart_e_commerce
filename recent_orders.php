<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n";
echo "╔══════════════════════════════════════════════════════════════════════════════╗\n";
echo "║                          RECENT ORDERS - SMARTCART                           ║\n";
echo "╚══════════════════════════════════════════════════════════════════════════════╝\n";

$orders = DB::select("
    SELECT
        id,
        order_number,
        user_id,
        status,
        total,
        CONCAT(customer_first_name, ' ', customer_last_name) as customer_name,
        customer_email,
        payment_status,
        created_at
    FROM orders
    ORDER BY created_at DESC
    LIMIT 25
");

if (count($orders) > 0) {
    echo "\n";
    echo str_pad("ID", 6) . " ";
    echo str_pad("Order Number", 20) . " ";
    echo str_pad("Status", 12) . " ";
    echo str_pad("Payment", 12) . " ";
    echo str_pad("Total", 12) . " ";
    echo str_pad("Customer", 25) . " ";
    echo "Date\n";
    echo str_repeat("─", 120) . "\n";

    foreach ($orders as $order) {
        echo str_pad($order->id, 6) . " ";
        echo str_pad($order->order_number, 20) . " ";
        echo str_pad(ucfirst($order->status), 12) . " ";
        echo str_pad(ucfirst($order->payment_status), 12) . " ";
        echo str_pad('$' . number_format($order->total, 2), 12) . " ";
        echo str_pad(substr($order->customer_name, 0, 24), 25) . " ";
        echo date('Y-m-d H:i', strtotime($order->created_at)) . "\n";
    }

    echo str_repeat("─", 120) . "\n";
    echo "Total Orders: " . count($orders) . "\n";
} else {
    echo "\n📭 No orders found.\n";
    echo "\nℹ️  Orders will appear here once customers start placing them.\n";
}

echo "\n";
