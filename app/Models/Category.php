<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasUlids;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'path',
        'icon',
        'is_active',
        'parent_id',
        'order',
        'metadata',
        'image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'metadata' => 'array',
        'products_count' => 'integer',
        'order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Children categories relationship
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Products relationship
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Scope for active categories
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for parent categories
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    // Check if category has children
    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }

    // Method to update products count
    public function updateProductsCount(): void
    {
        $this->products_count = $this->products()->count();
        $this->save();
    }
}
