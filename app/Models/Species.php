<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Species extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_url',
        'scientific_name',
        'habitat_info',
        'meta_tags',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'habitat_info' => 'array',
        'meta_tags' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($species) {
            if (empty($species->slug)) {
                $species->slug = Str::slug($species->name);
            }
        });
    }

    /**
     * Get all builds for this species
     */
    public function builds(): HasMany
    {
        return $this->hasMany(Build::class);
    }
}
