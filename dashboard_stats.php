<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$results = DB::select("
    SELECT
        (SELECT COUNT(*) FROM products WHERE is_active = true) as active_products,
        (SELECT COUNT(*) FROM categories WHERE is_active = true) as active_categories,
        (SELECT COUNT(*) FROM users) as total_customers,
        (SELECT COUNT(*) FROM orders WHERE status IN ('completed', 'processing', 'shipped', 'delivered')) as total_orders,
        (SELECT SUM(total) FROM orders WHERE status IN ('completed', 'processing', 'shipped', 'delivered')) as total_revenue,
        (SELECT COUNT(*) FROM orders WHERE DATE(created_at) = CURDATE()) as today_orders,
        (SELECT SUM(total) FROM orders WHERE DATE(created_at) = CURDATE()) as today_revenue,
        (SELECT COUNT(*) FROM reviews) as total_reviews
");

if (count($results) > 0) {
    $stats = $results[0];

    echo "\n";
    echo "╔═══════════════════════════════════════════════════════════╗\n";
    echo "║          SMARTCART DASHBOARD STATISTICS                  ║\n";
    echo "╠═══════════════════════════════════════════════════════════╣\n";
    echo "║                                                           ║\n";
    echo "║  📦 Active Products:        " . str_pad($stats->active_products, 25) . "║\n";
    echo "║  📁 Active Categories:      " . str_pad($stats->active_categories, 25) . "║\n";
    echo "║  👥 Total Customers:        " . str_pad($stats->total_customers, 25) . "║\n";
    echo "║  🛒 Total Orders:           " . str_pad($stats->total_orders, 25) . "║\n";
    echo "║  💰 Total Revenue:          " . str_pad('$' . number_format($stats->total_revenue ?? 0, 2), 25) . "║\n";
    echo "║                                                           ║\n";
    echo "║  📊 TODAY'S ACTIVITY:                                     ║\n";
    echo "║  └─ Orders Today:          " . str_pad($stats->today_orders, 25) . "║\n";
    echo "║  └─ Revenue Today:         " . str_pad('$' . number_format($stats->today_revenue ?? 0, 2), 25) . "║\n";
    echo "║                                                           ║\n";
    echo "║  ⭐ Total Reviews:          " . str_pad($stats->total_reviews, 25) . "║\n";
    echo "║                                                           ║\n";
    echo "╚═══════════════════════════════════════════════════════════╝\n";
    echo "\n";
} else {
    echo "\n⚠ No statistics available\n\n";
}
