<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $code
 * @property string|null $description
 * @property string $type
 * @property string $value
 * @property string|null $min_purchase
 * @property int|null $usage_limit
 * @property int $usage_count
 * @property int|null $per_user_limit
 * @property \Illuminate\Support\Carbon|null $starts_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon active()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereMinPurchase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon wherePerUserLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUsageCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUsageLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereValue($value)
 * @mixin \Eloquent
 */
class Coupon extends Model
{
    protected $fillable = [
        'code',
        'description',
        'type',
        'value',
        'min_purchase',
        'usage_limit',
        'usage_count',
        'per_user_limit',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
        'per_user_limit' => 'integer',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Check if coupon is valid
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->starts_at && now()->isBefore($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && now()->isAfter($this->expires_at)) {
            return false;
        }

        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($this->min_purchase && $subtotal < $this->min_purchase) {
            return 0;
        }

        if ($this->type === 'fixed') {
            return min($this->value, $subtotal);
        }

        // Percentage discount
        return ($subtotal * $this->value) / 100;
    }

    /**
     * Increment usage count
     */
    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    /**
     * Scope to get active coupons
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            });
    }
}
