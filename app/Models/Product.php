<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_type_id',
        'name',
        'slug',
        'description',
        'brand',
        'model',
        'price',
        'image_url',
        'specifications',
        'meta_tags',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'is_active',
        'popularity_score',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'specifications' => 'array',
        'meta_tags' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Get the product type
     */
    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * Get all affiliate links for this product
     */
    public function affiliateLinks(): HasMany
    {
        return $this->hasMany(AffiliateLink::class);
    }

    /**
     * Get all builds that include this product
     */
    public function builds(): BelongsToMany
    {
        return $this->belongsToMany(Build::class, 'build_product')
            ->withPivot(['role', 'quantity', 'sort_order', 'notes'])
            ->withTimestamps();
    }
}
