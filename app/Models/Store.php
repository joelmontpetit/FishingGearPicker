<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'website_url',
        'logo_url',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($store) {
            if (empty($store->slug)) {
                $store->slug = Str::slug($store->name);
            }
        });
    }

    /**
     * Get all affiliate links for this store
     */
    public function affiliateLinks(): HasMany
    {
        return $this->hasMany(AffiliateLink::class);
    }
}
