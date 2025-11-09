<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Technique extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_url',
        'meta_tags',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'meta_tags' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($technique) {
            if (empty($technique->slug)) {
                $technique->slug = Str::slug($technique->name);
            }
        });
    }

    /**
     * Get all builds for this technique
     */
    public function builds(): HasMany
    {
        return $this->hasMany(Build::class);
    }
}
