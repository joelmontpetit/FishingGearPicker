<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSeo extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_key',
        'page_name',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'og_tags',
        'is_active',
    ];

    protected $casts = [
        'og_tags' => 'array',
        'is_active' => 'boolean',
    ];
}
