<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'MacBook Pro 16"',
                'slug' => 'macbook-pro-16',
                'description' => 'Powerful laptop for professionals with M3 Pro chip',
                'short_description' => 'The ultimate laptop for power users',
                'price' => 2499.00,
                'compare_price' => 2799.00,
                'sku' => 'MBP-16-001',
                'stock' => 15,
                'is_active' => true,
                'is_featured' => true,
                'categories' => ['laptops'],
            ],
            [
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'description' => 'Latest iPhone with titanium design and A17 Pro chip',
                'short_description' => 'The most powerful iPhone yet',
                'price' => 999.00,
                'compare_price' => 1099.00,
                'sku' => 'IPH-15P-001',
                'stock' => 50,
                'is_active' => true,
                'is_featured' => true,
                'categories' => ['smartphones'],
            ],
            [
                'name' => 'Samsung Galaxy Tab S9',
                'slug' => 'samsung-galaxy-tab-s9',
                'description' => 'Premium Android tablet with S Pen',
                'short_description' => 'Versatile tablet for work and play',
                'price' => 799.00,
                'sku' => 'TAB-S9-001',
                'stock' => 25,
                'is_active' => true,
                'is_featured' => true,
                'categories' => ['tablets'],
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'slug' => 'sony-wh-1000xm5',
                'description' => 'Premium noise-cancelling headphones',
                'short_description' => 'Best-in-class noise cancellation',
                'price' => 399.00,
                'compare_price' => 449.00,
                'sku' => 'SONY-WH-001',
                'stock' => 40,
                'is_active' => true,
                'is_featured' => true,
                'categories' => ['electronics-accessories'],
            ],
            [
                'name' => 'Nike Air Max 2024',
                'slug' => 'nike-air-max-2024',
                'description' => 'Comfortable running shoes with air cushioning',
                'short_description' => 'Step up your running game',
                'price' => 159.00,
                'sku' => 'NIKE-AM-001',
                'stock' => 100,
                'is_active' => true,
                'categories' => ['shoes'],
            ],
            [
                'name' => 'Ergonomic Office Chair',
                'slug' => 'ergonomic-office-chair',
                'description' => 'Premium ergonomic chair for long work hours',
                'short_description' => 'Comfort meets productivity',
                'price' => 449.00,
                'sku' => 'CHAIR-ERG-001',
                'stock' => 20,
                'is_active' => true,
                'categories' => ['furniture'],
            ],
            [
                'name' => 'Smart Coffee Maker',
                'slug' => 'smart-coffee-maker',
                'description' => 'WiFi-enabled coffee maker with app control',
                'short_description' => 'Perfect brew every morning',
                'price' => 199.00,
                'sku' => 'COFFEE-SM-001',
                'stock' => 35,
                'is_active' => true,
                'categories' => ['kitchen'],
            ],
            [
                'name' => 'Yoga Mat Pro',
                'slug' => 'yoga-mat-pro',
                'description' => 'Non-slip yoga mat for all levels',
                'short_description' => 'Find your zen',
                'price' => 59.00,
                'sku' => 'YOGA-MAT-001',
                'stock' => 75,
                'is_active' => true,
                'categories' => ['exercise-equipment'],
            ],
        ];

        foreach ($products as $productData) {
            $categorySlug = $productData['categories'];
            unset($productData['categories']);

            $product = Product::create($productData);

            // Attach categories
            foreach ($categorySlug as $slug) {
                $category = Category::where('slug', $slug)->first();
                if ($category) {
                    $product->categories()->attach($category->id);
                }
            }
        }
    }
}
