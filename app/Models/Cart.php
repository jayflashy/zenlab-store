<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasUlids;
    //

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    public static function getCurrentCart()
    {
        if (Auth::check()) {
            // For logged in users
            return self::firstOrCreate(
                ['user_id' => Auth::id(), 'status' => 'active'],
                ['session_id' => session()->getId()]
            );
        } else {
            // For guests
            return self::firstOrCreate(
                ['session_id' => session()->getId(), 'status' => 'active'],
                ['user_id' => null]
            );
        }
    }

    // Method to merge guest cart with user cart on login
    public static function mergeGuestCart($userId, $sessionId)
    {
        $userCart = self::firstOrCreate(['user_id' => $userId, 'status' => 'active']);
        $guestCart = self::with('items')->where('session_id', $sessionId)->whereNull('user_id')->first();

        if (! $guestCart) {
            return $userCart;
        }
        try {
            DB::transaction(function () use ($guestCart, $userCart) {
                foreach ($guestCart->items as $item) {
                    $existingItem = CartItem::where('cart_id', $userCart->id)
                        ->where('product_id', $item->product_id)
                        ->where('license_type', $item->license_type)
                        ->where('extended_support', $item->extended_support)
                        ->first();

                    if ($existingItem) {
                        $existingItem->quantity = min($existingItem->quantity + $item->quantity, 10);
                        $existingItem->save();
                    } else {
                        // Clone item to new cart
                        $item->cart_id = $userCart->id;
                        $item->save();
                    }
                }

                // Delete the guest cart after merging
                $guestCart->delete();
            });
        } catch (\Exception $e) {
            \Log::error('Failed to merge guest cart: '.$e->getMessage());
        }

        return $userCart;
    }
}
