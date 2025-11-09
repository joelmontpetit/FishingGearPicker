<?php

namespace App\View\Composers;

use App\Models\SeoMeta;
use Illuminate\View\View;

class SeoComposer
{
    /**
     * Injecter les données SEO dans la vue
     */
    public function compose(View $view): void
    {
        // Récupérer les données de la vue
        $data = $view->getData();

        $seoMeta = null;
        $pageType = null;
        $entityId = null;
        $slug = null;

        // Déterminer le type de page et l'entité
        // Vérifier que c'est un objet unique et non une collection
        if (isset($data['build']) && is_object($data['build']) && !$data['build'] instanceof \Illuminate\Support\Collection) {
            $pageType = 'build';
            $entityId = $data['build']->id;
        } elseif (isset($data['technique']) && is_object($data['technique']) && !$data['technique'] instanceof \Illuminate\Support\Collection) {
            $pageType = 'technique';
            $entityId = $data['technique']->id;
        } elseif (isset($data['species']) && is_object($data['species']) && !$data['species'] instanceof \Illuminate\Support\Collection) {
            $pageType = 'species';
            $entityId = $data['species']->id;
        } elseif (isset($data['product']) && is_object($data['product']) && !$data['product'] instanceof \Illuminate\Support\Collection) {
            $pageType = 'product';
            $entityId = $data['product']->id;
        } elseif (isset($data['productType']) && is_object($data['productType']) && !$data['productType'] instanceof \Illuminate\Support\Collection) {
            $pageType = 'product_type';
            $entityId = $data['productType']->id;
        }

        // Détecter les pages index par le nom de la vue
        $viewName = $view->getName();
        if ($viewName === 'home') {
            $pageType = 'home';
            $slug = 'home';
        } elseif ($viewName === 'techniques.index') {
            $pageType = 'techniques-index';
            $slug = 'techniques-index';
        } elseif ($viewName === 'species.index') {
            $pageType = 'species-index';
            $slug = 'species-index';
        }

        // Récupérer les metas depuis la base de données
        if ($pageType) {
            $seoMeta = SeoMeta::getForPage($pageType, $entityId, $slug);
        }

        // Si pas de metas personnalisées, utiliser les valeurs par défaut
        if (!$seoMeta) {
            $defaults = $this->getDefaultMetas($pageType, $data);
            $seoMeta = (object) [
                'meta_title' => $defaults['meta_title'] ?? 'FishingGearPicker',
                'meta_description' => $defaults['meta_description'] ?? 'Complete fishing gear recommendations',
                'meta_keywords' => $defaults['meta_keywords'] ?? '',
                'og_title' => $defaults['og_title'] ?? null,
                'og_description' => $defaults['og_description'] ?? null,
                'og_image' => $defaults['og_image'] ?? null,
                'twitter_card' => $defaults['twitter_card'] ?? 'summary_large_image',
            ];
        }

        // Utiliser OG title/description si non définis
        if (!$seoMeta->og_title) {
            $seoMeta->og_title = $seoMeta->meta_title;
        }
        if (!$seoMeta->og_description) {
            $seoMeta->og_description = $seoMeta->meta_description;
        }

        $view->with('seoMeta', $seoMeta);
    }

    /**
     * Récupérer les metas par défaut basés sur le type de page
     */
    private function getDefaultMetas(?string $pageType, array $data): array
    {
        return match ($pageType) {
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
            'technique' => [
                'meta_title' => ($data['technique']->name ?? 'Technique') . ' - Fishing Gear Builds | FishingGearPicker',
                'meta_description' => 'Discover complete fishing gear builds for ' . ($data['technique']->name ?? 'this technique') . '. ' . substr($data['technique']->description ?? '', 0, 120),
                'meta_keywords' => ($data['technique']->name ?? '') . ', fishing gear, fishing builds',
            ],
            'species' => [
                'meta_title' => ($data['species']->name ?? 'Species') . ' Fishing Gear - Complete Builds | FishingGearPicker',
                'meta_description' => 'Find the best fishing gear for ' . ($data['species']->name ?? 'this species') . '. ' . substr($data['species']->description ?? '', 0, 120),
                'meta_keywords' => ($data['species']->name ?? '') . ' fishing, fishing gear, fishing builds',
            ],
            'build' => [
                'meta_title' => ($data['build']->name ?? 'Build') . ' | FishingGearPicker',
                'meta_description' => $data['build']->description ?? 'Complete fishing gear build with affiliate links.',
                'meta_keywords' => ($data['build']->technique->name ?? '') . ', ' . ($data['build']->species->name ?? '') . ', fishing build',
                'og_image' => $data['build']->image_url ?? null,
            ],
            'product' => [
                'meta_title' => ($data['product']->name ?? 'Product') . ' - ' . ($data['product']->brand ?? '') . ' | FishingGearPicker',
                'meta_description' => $data['product']->description ?? 'Quality fishing gear with affiliate links from top retailers.',
                'meta_keywords' => ($data['product']->name ?? '') . ', ' . ($data['product']->brand ?? '') . ', fishing gear',
                'og_image' => $data['product']->image_url ?? null,
            ],
            default => SeoMeta::getDefaultMetas($pageType ?? 'home'),
        };
    }
}

