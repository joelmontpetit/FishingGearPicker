<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'sort_order',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($productType) {
            if (empty($productType->slug)) {
                $productType->slug = Str::slug($productType->name);
            }
        });
    }

    /**
     * Get all products of this type
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
