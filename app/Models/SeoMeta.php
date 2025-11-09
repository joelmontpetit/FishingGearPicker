<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_type',
        'entity_id',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'twitter_card',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Récupérer les metas pour une page spécifique
     */
    public static function getForPage(string $pageType, ?int $entityId = null, ?string $slug = null): ?self
    {
        $query = self::where('page_type', $pageType)->where('is_active', true);

        if ($entityId) {
            $query->where('entity_id', $entityId);
        } elseif ($slug) {
            $query->where('slug', $slug);
        }

        return $query->first();
    }

    /**
     * Récupérer ou créer les metas par défaut
     */
    public static function getDefaultMetas(string $pageType): array
    {
        $defaults = [
            'home' => [
                'meta_title' => 'FishingGearPicker - Complete Fishing Gear Recommendations',
                'meta_description' => 'Find the perfect fishing gear setup for your technique and target species. Complete builds with affiliate links from top retailers.',
                'meta_keywords' => 'fishing gear, fishing equipment, fishing rods, fishing reels, fishing tackle',
            ],
            'techniques-index' => [
                'meta_title' => 'All Fishing Techniques - FishingGearPicker',
                'meta_description' => 'Browse all fishing techniques and discover specialized fishing gear recommendations for each method.',
                'meta_keywords' => 'fishing techniques, carolina rig, drop shot, texas rig, ned rig',
            ],
            'species-index' => [
                'meta_title' => 'All Fish Species - FishingGearPicker',
                'meta_description' => 'Browse all target fish species and discover specialized fishing gear recommendations for each one.',
                'meta_keywords' => 'fish species, bass fishing, walleye fishing, trout fishing',
            ],
        ];

        return $defaults[$pageType] ?? [
            'meta_title' => 'FishingGearPicker',
            'meta_description' => 'Complete fishing gear recommendations',
            'meta_keywords' => '',
        ];
    }
}
