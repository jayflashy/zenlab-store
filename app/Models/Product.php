<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasUlids, SoftDeletes;
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
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
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getFinalPriceAttribute()
    {
        $price = $this->is_free ? 0 : $this->regular_price;
        if ($this->discount > 0 && !$this->is_free) {
            $price = $price - ($price * $this->discount / 100);
        }
        return round($price, 2);
    }

    public function getDownloadLinkAttribute()
    {
        return $this->download_type === 'link' ? $this->file_path : my_asset($this->file_path);
    }
}
