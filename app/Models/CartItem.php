<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'cart_id',
        'product_id',
        'license_type',
        'extended_support',
        'price',
        'quantity',
        'total',
        'support_price'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
