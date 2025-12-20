<?php

return [
    'products_per_page' => env('PRODUCTS_PER_PAGE', 12),
    'orders_per_page' => env('ORDERS_PER_PAGE', 10),

    'tax_rate' => 0.08, // 8% tax

    'currency' => [
        'code' => 'USD',
        'symbol' => '$',
    ],

    'order_statuses' => [
        'pending' => 'Pending',
        'processing' => 'Processing',
        'shipped' => 'Shipped',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled',
        'refunded' => 'Refunded',
    ],

    'payment_methods' => [
        'card' => 'Credit/Debit Card',
        'paypal' => 'PayPal',
    ],
];
