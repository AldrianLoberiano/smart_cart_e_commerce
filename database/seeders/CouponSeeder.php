<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'description' => 'Welcome discount - 10% off your first order',
                'type' => 'percentage',
                'value' => 10,
                'min_purchase' => 50.00,
                'is_active' => true,
            ],
            [
                'code' => 'SAVE20',
                'description' => '20% off on orders over $100',
                'type' => 'percentage',
                'value' => 20,
                'min_purchase' => 100.00,
                'usage_limit' => 100,
                'is_active' => true,
            ],
            [
                'code' => 'FLAT50',
                'description' => '$50 off on orders over $200',
                'type' => 'fixed',
                'value' => 50,
                'min_purchase' => 200.00,
                'is_active' => true,
            ],
            [
                'code' => 'FREESHIP',
                'description' => 'Free shipping on all orders',
                'type' => 'fixed',
                'value' => 10,
                'min_purchase' => null,
                'is_active' => true,
                'expires_at' => now()->addMonths(3),
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}
