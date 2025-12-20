<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'compare_price',
        'cost',
        'sku',
        'stock',
        'low_stock_threshold',
        'track_stock',
        'is_active',
        'is_featured',
        'images',
        'weight',
        'weight_unit',
        'meta_data',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost' => 'decimal:2',
        'weight' => 'decimal:2',
        'stock' => 'integer',
        'low_stock_threshold' => 'integer',
        'track_stock' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'images' => 'array',
        'meta_data' => 'array',
    ];

    /**
     * Get all categories for this product
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get all reviews for this product
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get all order items for this product
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get wishlists containing this product
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Scope to get only active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
            ->where('is_active', true);
    }

    /**
     * Scope to get in-stock products
     */
    public function scopeInStock($query)
    {
        return $query->where(function ($q) {
            $q->where('track_stock', false)
                ->orWhere('stock', '>', 0);
        });
    }

    /**
     * Check if product is in stock
     */
    public function isInStock(): bool
    {
        if (!$this->track_stock) {
            return true;
        }
        return $this->stock > 0;
    }

    /**
     * Check if product is low in stock
     */
    public function isLowStock(): bool
    {
        if (!$this->track_stock) {
            return false;
        }
        return $this->stock <= $this->low_stock_threshold && $this->stock > 0;
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute(): ?float
    {
        if (!$this->compare_price || $this->compare_price <= $this->price) {
            return null;
        }
        return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
    }

    /**
     * Get average rating
     */
    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()
            ->where('is_approved', true)
            ->avg('rating') ?? 0;
    }

    /**
     * Get primary image
     */
    public function getPrimaryImageAttribute(): ?string
    {
        return $this->images[0] ?? null;
    }

    /**
     * Get the route key for the model
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Decrement stock
     */
    public function decrementStock(int $quantity): bool
    {
        if (!$this->track_stock) {
            return true;
        }

        if ($this->stock < $quantity) {
            return false;
        }

        $this->decrement('stock', $quantity);
        return true;
    }

    /**
     * Increment stock
     */
    public function incrementStock(int $quantity): void
    {
        if ($this->track_stock) {
            $this->increment('stock', $quantity);
        }
    }
}
