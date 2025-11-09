<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Build extends Model
{
    use HasFactory;

    protected $fillable = [
        'technique_id',
        'species_id',
        'name',
        'slug',
        'description',
        'budget_tier',
        'total_price',
        'image_url',
        'meta_tags',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'is_featured',
        'is_active',
        'views_count',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'meta_tags' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($build) {
            if (empty($build->slug)) {
                $build->slug = Str::slug($build->name);
            }
        });
    }

    /**
     * Get the technique
     */
    public function technique(): BelongsTo
    {
        return $this->belongsTo(Technique::class);
    }

    /**
     * Get the species
     */
    public function species(): BelongsTo
    {
        return $this->belongsTo(Species::class);
    }

    /**
     * Get all products in this build
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'build_product')
            ->withPivot(['role', 'quantity', 'sort_order', 'notes'])
            ->withTimestamps()
            ->orderBy('build_product.sort_order');
    }

    /**
     * Increment views counter
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
