<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AffiliateLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'store_id',
        'affiliate_url',
        'price',
        'in_stock',
        'is_active',
        'last_checked_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'in_stock' => 'boolean',
        'is_active' => 'boolean',
        'last_checked_at' => 'datetime',
    ];

    /**
     * Get the product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the store
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
