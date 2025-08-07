<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    use HasUlids;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
        'license_type',
        'extended_support',
        'support_price',
        'total',
        'support_end_date',
        'license_code',
    ];

    protected $casts = [
        'support_end_date' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the review left by the currently authenticated user for this product.
     */
    public function userReview(): HasOne
    {
        return $this->hasOne(Rating::class, 'product_id', 'product_id')
            ->where('user_id', Auth::id());
    }

    /**
     * Determine if this ordered item is downloadable
     */
    public function isDownloadable(): bool
    {
        return $this->support_end_date === null
            ? true
            : $this->support_end_date->isFuture();
    }

    protected static function booted(): void
    {
        static::creating(function ($order) {
            if (is_null($order->uid)) {
                $max = static::max('uid') ?? 0;
                $order->uid = $max + 1;
            }
        });
    }

    public function scopeCompleted($query)
    {
        return $query->where('payment_status', 'completed');
    }
}
