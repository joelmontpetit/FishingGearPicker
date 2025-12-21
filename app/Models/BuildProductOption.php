<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuildProductOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'build_id',
        'product_id',
        'role',
        'sort_order',
        'is_recommended',
        'price_tier',
        'notes',
    ];

    protected $casts = [
        'is_recommended' => 'boolean',
    ];

    /**
     * Get the build that owns this product option
     */
    public function build(): BelongsTo
    {
        return $this->belongsTo(Build::class);
    }

    /**
     * Get the product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope to get options by role
     */
    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope to get recommended options
     */
    public function scopeRecommended($query)
    {
        return $query->where('is_recommended', true);
    }

    /**
     * Scope to get options by price tier
     */
    public function scopeByTier($query, string $tier)
    {
        return $query->where('price_tier', $tier);
    }

    /**
     * Scope to order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
