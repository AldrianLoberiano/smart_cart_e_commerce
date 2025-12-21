<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$results = DB::select("
    SELECT 
        sku,
        COUNT(*) as count
    FROM products
    WHERE sku IS NOT NULL
    GROUP BY sku
    HAVING COUNT(*) > 1
    LIMIT 25
");

if (count($results) > 0) {
    echo "\nDuplicate SKUs found:\n";
    echo str_repeat('-', 50) . "\n";
    foreach ($results as $row) {
        echo "SKU: {$row->sku} | Count: {$row->count}\n";
    }
    echo str_repeat('-', 50) . "\n";
    echo "Total duplicate SKUs: " . count($results) . "\n\n";
} else {
    echo "\n✓ No duplicate SKUs found!\n\n";
}
