<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory;
    use HasUlids;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'phone',
        'country',
        'address',
        'email_verify',
        'status',
        'image',
        'update_notify',
        'trx_notify',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'update_notify' => 'boolean',
            'trx_notify' => 'boolean',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get the user's notification preferences.
     */
    public function notificationPreferences(): HasMany
    {
        return $this->hasMany(NotificationPreference::class);
    }

    /**
     * Check if the user is subscribed to updates for a product.
     */
    public function isSubscribedToProductUpdates(int $productId): bool
    {
        return $this->notificationPreferences()
            ->where('product_id', $productId)
            ->where('type', 'product_update')
            ->where('active', true)
            ->exists();
    }

    // wishlist
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function purchasesCount()
    {
        return $this->orders()
            ->where('order_status', 'completed')
            ->where('payment_status', 'completed')
            ->withCount('items')
            ->get()
            ->sum('items_count');
    }

    public static function generateUniqueUsername(string $name): string
    {
        $baseUsername = self::generateUsername($name);
        $username = $baseUsername;
        $counter = 1;

        while (self::where('username', $username)->exists()) {
            $username = $baseUsername . '_' . $counter++;
        }

        return $username;
    }
}
