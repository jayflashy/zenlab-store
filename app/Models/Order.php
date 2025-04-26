<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasUlids, SoftDeletes;

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


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
