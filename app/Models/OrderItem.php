<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasUlids;
    use SoftDeletes;

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
        if ($this->support_end_date < now()) {
            return false;
        }
        return true;
    }
}
