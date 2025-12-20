<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductService
{
    /**
     * Get filtered and paginated products
     */
    public function getProducts(array $filters = []): LengthAwarePaginator
    {
        $query = Product::query()->with('categories')->active();

        // Category filter
        if (!empty($filters['category'])) {
            $query->whereHas('categories', function (Builder $q) use ($filters) {
                $q->where('slug', $filters['category']);
            });
        }

        // Search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Price range filter
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        // Stock filter
        if (!empty($filters['in_stock'])) {
            $query->inStock();
        }

        // Featured filter
        if (!empty($filters['featured'])) {
            $query->where('is_featured', true);
        }

        // Sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';

        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy($sortBy, $sortOrder);
        }

        $perPage = $filters['per_page'] ?? config('app.products_per_page', 12);

        return $query->paginate($perPage);
    }

    /**
     * Get featured products
     */
    public function getFeaturedProducts(int $limit = 8)
    {
        return Product::featured()
            ->with('categories')
            ->limit($limit)
            ->get();
    }

    /**
     * Search products
     */
    public function search(string $query, int $limit = 10)
    {
        return Product::active()
            ->where(function (Builder $q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('sku', 'like', "%{$query}%");
            })
            ->limit($limit)
            ->get();
    }

    /**
     * Get related products
     */
    public function getRelatedProducts(Product $product, int $limit = 4)
    {
        $categoryIds = $product->categories->pluck('id');

        return Product::active()
            ->where('id', '!=', $product->id)
            ->whereHas('categories', function (Builder $q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            })
            ->inStock()
            ->limit($limit)
            ->get();
    }
}
