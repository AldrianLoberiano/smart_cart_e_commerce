<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get basic price statistics
$stats = DB::select("
    SELECT
        COUNT(*) as product_count,
        MIN(price) as min_price,
        MAX(price) as max_price,
        AVG(price) as avg_price
    FROM products
    WHERE is_active = true
");

// Calculate median separately (MySQL doesn't have MEDIAN function)
$medianResult = DB::select("
    SELECT AVG(price) as median_price
    FROM (
        SELECT price,
               ROW_NUMBER() OVER (ORDER BY price) as row_num,
               COUNT(*) OVER () as total_count
        FROM products
        WHERE is_active = true
    ) as sorted
    WHERE row_num IN (FLOOR((total_count + 1) / 2), FLOOR((total_count + 2) / 2))
");

if (count($stats) > 0) {
    $data = $stats[0];
    $median = count($medianResult) > 0 ? $medianResult[0]->median_price : 0;

    echo "\n";
    echo "╔═══════════════════════════════════════════════════════════╗\n";
    echo "║          PRODUCT PRICING ANALYSIS                         ║\n";
    echo "╠═══════════════════════════════════════════════════════════╣\n";
    echo "║                                                           ║\n";
    echo "║  📊 Total Products:         " . str_pad($data->product_count, 25) . "║\n";
    echo "║                                                           ║\n";
    echo "║  💵 Price Range:                                          ║\n";
    echo "║  ├─ Minimum:               " . str_pad('$' . number_format($data->min_price, 2), 25) . "║\n";
    echo "║  ├─ Maximum:               " . str_pad('$' . number_format($data->max_price, 2), 25) . "║\n";
    echo "║  ├─ Average:               " . str_pad('$' . number_format($data->avg_price, 2), 25) . "║\n";
    echo "║  └─ Median:                " . str_pad('$' . number_format($median, 2), 25) . "║\n";
    echo "║                                                           ║\n";

    // Price distribution
    $distribution = DB::select("
        SELECT
            CASE
                WHEN price < 50 THEN 'Under $50'
                WHEN price >= 50 AND price < 100 THEN '$50 - $100'
                WHEN price >= 100 AND price < 200 THEN '$100 - $200'
                WHEN price >= 200 AND price < 500 THEN '$200 - $500'
                ELSE '$500+'
            END as price_range,
            COUNT(*) as count
        FROM products
        WHERE is_active = true
        GROUP BY price_range
        ORDER BY MIN(price)
    ");

    if (count($distribution) > 0) {
        echo "║  📈 Price Distribution:                                   ║\n";
        foreach ($distribution as $range) {
            $label = str_pad($range->price_range, 15);
            $countStr = str_pad($range->count . ' products', 12);
            echo "║  └─ " . $label . ": " . $countStr . "             ║\n";
        }
        echo "║                                                           ║\n";
    }

    echo "╚═══════════════════════════════════════════════════════════╝\n";
    echo "\n";
} else {
    echo "\n⚠ No active products found\n\n";
}
