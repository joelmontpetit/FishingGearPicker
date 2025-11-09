<?php

namespace Database\Seeders;

use App\Models\Build;
use App\Models\SeoMeta;
use App\Models\Species;
use App\Models\Technique;
use Illuminate\Database\Seeder;

class SeoMetaSeeder extends Seeder
{
    public function run(): void
    {
        // SEO pour la page d'accueil
        SeoMeta::create([
            'page_type' => 'home',
            'slug' => 'home',
            'meta_title' => 'FishingGearPicker - Complete Fishing Gear Recommendations',
            'meta_description' => 'Find the perfect fishing gear setup for your technique and target species. Complete builds with affiliate links from top retailers. Carolina Rig, Ned Rig, Drop Shot, and more.',
            'meta_keywords' => 'fishing gear, fishing equipment, bass fishing, fishing rods, fishing reels, carolina rig, ned rig, fishing tackle',
            'og_title' => 'FishingGearPicker - Your Fishing Gear Expert',
            'og_description' => 'Discover complete fishing gear builds for every technique and species. Expert recommendations with affiliate links.',
            'is_active' => true,
        ]);

        // SEO pour la page index des techniques
        SeoMeta::create([
            'page_type' => 'techniques-index',
            'slug' => 'techniques-index',
            'meta_title' => 'All Fishing Techniques - Complete Gear Guides | FishingGearPicker',
            'meta_description' => 'Browse all fishing techniques including Carolina Rig, Ned Rig, Drop Shot, and Texas Rig. Discover specialized fishing gear recommendations for each method.',
            'meta_keywords' => 'fishing techniques, carolina rig, drop shot, texas rig, ned rig, jigging, finesse fishing',
            'is_active' => true,
        ]);

        // SEO pour la page index des species
        SeoMeta::create([
            'page_type' => 'species-index',
            'slug' => 'species-index',
            'meta_title' => 'All Fish Species - Targeted Gear Recommendations | FishingGearPicker',
            'meta_description' => 'Browse all target fish species including Bass, Walleye, Pike, and Trout. Discover specialized fishing gear recommendations optimized for each species.',
            'meta_keywords' => 'fish species, bass fishing, walleye fishing, pike fishing, trout fishing, fishing gear',
            'is_active' => true,
        ]);

        // SEO pour Carolina Rig technique
        $carolinaRig = Technique::where('slug', 'carolina-rig')->first();
        if ($carolinaRig) {
            SeoMeta::create([
                'page_type' => 'technique',
                'entity_id' => $carolinaRig->id,
                'meta_title' => 'Carolina Rig Fishing - Complete Gear Guide & Builds | FishingGearPicker',
                'meta_description' => 'Master the Carolina Rig technique with our complete gear guides. Perfect for covering water and finding bass in various depths. Discover complete builds and equipment.',
                'meta_keywords' => 'carolina rig, carolina rig setup, bass fishing, fishing gear, carolina rig rod',
                'og_title' => 'Carolina Rig - Complete Fishing Gear Guide',
                'is_active' => true,
            ]);
        }

        // SEO pour Ned Rig technique
        $nedRig = Technique::where('slug', 'ned-rig')->first();
        if ($nedRig) {
            SeoMeta::create([
                'page_type' => 'technique',
                'entity_id' => $nedRig->id,
                'meta_title' => 'Ned Rig Fishing - Finesse Technique Guide & Gear | FishingGearPicker',
                'meta_description' => 'Learn the Ned Rig finesse technique. Perfect for pressured fish like walleye and bass. Complete gear setups with mushroom jig heads and buoyant plastics.',
                'meta_keywords' => 'ned rig, ned rig setup, finesse fishing, walleye fishing, mushroom jig head',
                'og_title' => 'Ned Rig - Finesse Fishing Technique Guide',
                'is_active' => true,
            ]);
        }

        // SEO pour Largemouth Bass species
        $largemouthBass = Species::where('slug', 'largemouth-bass')->first();
        if ($largemouthBass) {
            SeoMeta::create([
                'page_type' => 'species',
                'entity_id' => $largemouthBass->id,
                'meta_title' => 'Largemouth Bass Fishing Gear - Complete Builds & Equipment | FishingGearPicker',
                'meta_description' => 'Find the best fishing gear for Largemouth Bass. Complete setups for Carolina Rig, Texas Rig, and more. Expert recommendations for targeting trophy bass.',
                'meta_keywords' => 'largemouth bass, bass fishing, bass fishing gear, bass rod, bass reel',
                'og_title' => 'Largemouth Bass Fishing - Complete Gear Guide',
                'is_active' => true,
            ]);
        }

        // SEO pour Walleye species
        $walleye = Species::where('slug', 'walleye')->first();
        if ($walleye) {
            SeoMeta::create([
                'page_type' => 'species',
                'entity_id' => $walleye->id,
                'meta_title' => 'Walleye Fishing Gear - Complete Builds & Equipment | FishingGearPicker',
                'meta_description' => 'Discover the best fishing gear for Walleye. Finesse setups including Ned Rig, jigging rods, and specialized equipment for low-light conditions.',
                'meta_keywords' => 'walleye, walleye fishing, walleye gear, ned rig, walleye rod',
                'og_title' => 'Walleye Fishing - Complete Gear Guide',
                'is_active' => true,
            ]);
        }

        // SEO pour le build Carolina Rig
        $carolinaBuild = Build::where('slug', 'carolina-rig-largemouth-bass-beginner')->first();
        if ($carolinaBuild) {
            SeoMeta::create([
                'page_type' => 'build',
                'entity_id' => $carolinaBuild->id,
                'meta_title' => 'Carolina Rig Setup for Largemouth Bass - Beginner Build | FishingGearPicker',
                'meta_description' => 'Complete beginner Carolina Rig setup for Largemouth Bass fishing. Includes rod, reel, line, weights, hooks, and soft plastics with affiliate links.',
                'meta_keywords' => 'carolina rig setup, bass fishing, beginner fishing gear, carolina rig rod',
                'og_title' => 'Carolina Rig Beginner Build - Complete Setup',
                'is_active' => true,
            ]);
        }

        // SEO pour le build Ned Rig
        $nedBuild = Build::where('slug', 'ned-rig-walleye-finesse')->first();
        if ($nedBuild) {
            SeoMeta::create([
                'page_type' => 'build',
                'entity_id' => $nedBuild->id,
                'meta_title' => 'Ned Rig Setup for Walleye - Finesse Build | FishingGearPicker',
                'meta_description' => 'Complete finesse Ned Rig setup for Walleye fishing. Perfect for pressured fish in clear water. Includes spinning rod, reel, fluorocarbon, jig heads, and soft plastics.',
                'meta_keywords' => 'ned rig setup, walleye fishing, finesse fishing, ned rig for walleye',
                'og_title' => 'Ned Rig Walleye Build - Finesse Setup',
                'is_active' => true,
            ]);
        }

        $this->command->info('✅ SEO Metas seeded successfully!');
    }
}

