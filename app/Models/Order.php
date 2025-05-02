<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasUlids;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'email',
        'name',
        'code',
        'subtotal',
        'discount',
        'payment_receipt',
        'bank_reference',
        'total',
        'payment_method',
        'payment_status',
        'order_status',
        'notes',
        'cart_id',
        'payment_date',
    ];

    public function items() :HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the order is paid.
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'completed';
    }
}
