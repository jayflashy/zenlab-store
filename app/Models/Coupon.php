<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasUlids, SoftDeletes;
    //

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
    ];
}
