<?php

namespace App\Models;

use App\Enums\CouponType;
use App\Enums\DiscountType;
use Cache;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasUlids;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'code',
        'discount',
        'expires_at',
        'discount_type',
        'type',
        'product_id',
        'category_id',
        'limit',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'discount_type' => DiscountType::class,
        'type' => CouponType::class,
    ];

    /**
     * Scope a query to only include valid coupons.
     */
    public function scopeValid($query)
    {
        return $query->where(function ($query): void {
            $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
        })->where(function ($query): void {
            $query->whereNull('limit')->orWhere('limit', '>', 0);
        })->where('active', true);
    }

    /**
     * Get the product associated with the coupon.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the category associated with the coupon.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // clear cache
    protected static function boot()
    {
        parent::boot();
        static::saved(function (): void {
            self::refreshCache();
        });
        static::deleted(function (): void {
            self::refreshCache();
        });
    }

    /**
     * Refresh the coupons cache.
     */
    private static function refreshCache(): void
    {
        Cache::put('SiteCoupons', Coupon::all(), now()->addHours(24));
    }
}
