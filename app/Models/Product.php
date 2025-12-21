<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $short_description
 * @property string $price
 * @property string|null $compare_price
 * @property string|null $cost
 * @property string $sku
 * @property int $stock
 * @property int $low_stock_threshold
 * @property bool $track_stock
 * @property bool $is_active
 * @property bool $is_featured
 * @property array|null $images
 * @property string|null $weight
 * @property string $weight_unit
 * @property array|null $meta_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read float $average_rating
 * @property-read float|null $discount_percentage
 * @property-read string|null $primary_image
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Wishlist> $wishlists
 * @property-read int|null $wishlists_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product active()
 * @method static \Illuminate\Database\Eloquent\Builder|Product featured()
 * @method static \Illuminate\Database\Eloquent\Builder|Product inStock()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereComparePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLowStockThreshold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMetaData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTrackStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWeightUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product withoutTrashed()
 * @mixin \Eloquent
 */
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
