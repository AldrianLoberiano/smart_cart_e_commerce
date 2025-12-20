<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Latest electronic gadgets and devices',
                'is_active' => true,
                'sort_order' => 1,
                'children' => [
                    ['name' => 'Laptops', 'slug' => 'laptops'],
                    ['name' => 'Smartphones', 'slug' => 'smartphones'],
                    ['name' => 'Tablets', 'slug' => 'tablets'],
                    ['name' => 'Accessories', 'slug' => 'electronics-accessories'],
                ],
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Trendy clothing and accessories',
                'is_active' => true,
                'sort_order' => 2,
                'children' => [
                    ['name' => 'Men\'s Clothing', 'slug' => 'mens-clothing'],
                    ['name' => 'Women\'s Clothing', 'slug' => 'womens-clothing'],
                    ['name' => 'Shoes', 'slug' => 'shoes'],
                    ['name' => 'Accessories', 'slug' => 'fashion-accessories'],
                ],
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'description' => 'Everything for your home',
                'is_active' => true,
                'sort_order' => 3,
                'children' => [
                    ['name' => 'Furniture', 'slug' => 'furniture'],
                    ['name' => 'Kitchen', 'slug' => 'kitchen'],
                    ['name' => 'Garden', 'slug' => 'garden'],
                    ['name' => 'Decor', 'slug' => 'decor'],
                ],
            ],
            [
                'name' => 'Sports & Outdoors',
                'slug' => 'sports-outdoors',
                'description' => 'Gear up for your adventures',
                'is_active' => true,
                'sort_order' => 4,
                'children' => [
                    ['name' => 'Exercise Equipment', 'slug' => 'exercise-equipment'],
                    ['name' => 'Camping', 'slug' => 'camping'],
                    ['name' => 'Sports Gear', 'slug' => 'sports-gear'],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $category = Category::create($categoryData);

            foreach ($children as $childData) {
                Category::create([
                    'name' => $childData['name'],
                    'slug' => $childData['slug'],
                    'parent_id' => $category->id,
                    'is_active' => true,
                    'sort_order' => 0,
                ]);
            }
        }
    }
}
