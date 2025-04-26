<?php

namespace App\Models;

use App\Enums\DiscountType;
use App\Enums\Enums\CouponType;
use Cache;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasUlids, SoftDeletes;

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
        return $query->where(function ($query) {
            $query->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        })->where(function ($query) {
            $query->whereNull('limit')
                ->orWhere('limit', '>', 0);
        });
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
            Cache::forget('SiteCoupons');
        });
    }
}
