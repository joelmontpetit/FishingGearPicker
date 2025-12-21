<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
     * Get all products in this build (legacy pivot table)
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'build_product')
            ->withPivot(['role', 'quantity', 'sort_order', 'notes'])
            ->withTimestamps()
            ->orderBy('build_product.sort_order');
    }

    /**
     * Get all product options for this build (new system)
     */
    public function productOptions(): HasMany
    {
        return $this->hasMany(BuildProductOption::class);
    }

    /**
     * Get product options by role
     */
    public function getOptionsByRole(string $role)
    {
        return $this->productOptions()
            ->where('role', $role)
            ->with('product')
            ->ordered()
            ->get();
    }

    /**
     * Get recommended product for a role
     */
    public function getRecommendedOption(string $role)
    {
        return $this->productOptions()
            ->where('role', $role)
            ->where('is_recommended', true)
            ->with('product')
            ->first();
    }

    /**
     * Get all user saved builds based on this build
     */
    public function savedBuilds(): HasMany
    {
        return $this->hasMany(UserSavedBuild::class);
    }

    /**
     * Increment views counter
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
