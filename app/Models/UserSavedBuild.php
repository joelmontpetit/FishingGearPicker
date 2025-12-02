<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class UserSavedBuild extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'build_id',
        'name',
        'slug',
        'notes',
        'is_public',
        'total_price',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'total_price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($savedBuild) {
            if (empty($savedBuild->slug)) {
                $savedBuild->slug = Str::slug($savedBuild->user_id . '-' . $savedBuild->name . '-' . now()->timestamp);
            }
        });
    }

    /**
     * Get the user who saved this build
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the base build template
     */
    public function build(): BelongsTo
    {
        return $this->belongsTo(Build::class);
    }

    /**
     * Get all products in this saved build
     */
    public function products(): HasMany
    {
        return $this->hasMany(UserSavedBuildProduct::class);
    }

    /**
     * Calculate the total price of all products
     */
    public function calculateTotal(): float
    {
        return $this->products()
            ->join('products', 'products.id', '=', 'user_saved_build_products.product_id')
            ->selectRaw('SUM(products.price * user_saved_build_products.quantity) as total')
            ->value('total') ?? 0;
    }

    /**
     * Update the total price
     */
    public function updateTotalPrice(): void
    {
        $this->update(['total_price' => $this->calculateTotal()]);
    }

    /**
     * Scope to get public builds
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope to get builds by user
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
