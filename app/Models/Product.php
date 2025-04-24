<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasUlids;
    use SoftDeletes;
    //

    /**
     * The attributes that are mass assignable.     *
     */
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'category_id',
        'type',
        'regular_price',
        'extended_price',
        'discount',
        'is_free',
        'image',
        'thumbnail',
        'file_path',
        'download_type',
        'screenshots',
        'demo_url',
        'downloads_count',
        'sales_count',
        'sales_boost',
        'featured',
        'tags',
        'version',
        'attributes',
        'metadata',
        'status',
        'publish_date',
        'download_link',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_free' => 'boolean',
        'featured' => 'boolean',
        'screenshots' => 'array',
        'tags' => 'array',
        'attributes' => 'array',
        'metadata' => 'array',
        'publish_date' => 'date',
        'regular_price' => 'decimal:2',
        'extended_price' => 'decimal:2',
        'discount' => 'integer',
        'downloads_count' => 'integer',
        'sales_count' => 'integer',
        'sales_boost' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getFinalPriceAttribute()
    {
        $price = $this->is_free ? 0 : $this->regular_price;
        if ($this->discount > 0 && ! $this->is_free) {
            $price = $price - ($price * $this->discount / 100);
        }

        return round($price, 2);
    }

    public function getFinalExtendedPriceAttribute()
    {
        $price = $this->is_free ? 0 : $this->extended_price;
        if ($this->discount > 0 && ! $this->is_free) {
            $price = $price - ($price * $this->discount / 100);
        }

        return round($price, 2);
    }

    public function getDownloadUrlAttribute()
    {
        if ($this->download_type === 'link') {
            // Return the URL only if it's valid, otherwise return a placeholder or null
            return filter_var($this->download_link, FILTER_VALIDATE_URL) ? $this->download_link : null;
        }

        return $this->file_path ? my_asset($this->file_path) : null;
    }

    public function getTotalSalesAttribute()
    {
        return $this->sales_count + $this->sales_boost;
    }

    public function getScreenshotImagesAttribute()
    {
        return array_merge([$this->image], $this->screenshots);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class)->where('status', 'approved');
    }

    public function allRatings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return round($this->ratings()->avg('stars'), 1);
    }

    public function ratingCount()
    {
        return $this->ratings()->count();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function commentCount()
    {
        return $this->comments()->approved()->count();
    }
}
