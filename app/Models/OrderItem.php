<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasUlids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
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
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
