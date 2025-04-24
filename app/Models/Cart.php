<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasUlids;
    //

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'status'
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
        $guestCart = self::where('session_id', $sessionId)->where('user_id', null)->first();

        if ($guestCart && $userCart) {
            // Move items from guest cart to user cart
            foreach ($guestCart->items as $item) {
                // Check if same product with same license exists in user cart
                $existingItem = CartItem::where('cart_id', $userCart->id)
                    ->where('product_id', $item->product_id)
                    ->where('license_type', $item->license_type)
                    ->where('extended_support', $item->extended_support)
                    ->first();

                if ($existingItem) {
                    // Update quantity if item exists
                    $existingItem->quantity += $item->quantity;
                    $existingItem->save();
                } else {
                    // Move item to user cart
                    $item->cart_id = $userCart->id;
                    $item->save();
                }
            }

            // Delete guest cart
            $guestCart->delete();
        } elseif ($guestCart) {
            // Just assign user ID to the guest cart
            $guestCart->user_id = $userId;
            $guestCart->session_id = null;
            $guestCart->save();
        }

        return $userCart;
    }
}
