<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSavedBuildProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_saved_build_id',
        'product_id',
        'role',
        'quantity',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Get the saved build
     */
    public function savedBuild(): BelongsTo
    {
        return $this->belongsTo(UserSavedBuild::class, 'user_saved_build_id');
    }

    /**
     * Get the product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope to get products by role
     */
    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }
}
