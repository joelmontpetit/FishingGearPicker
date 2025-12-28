<?php

namespace Database\Seeders;

use App\Models\AffiliateLink;
use App\Models\Build;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Species;
use App\Models\Store;
use App\Models\Technique;
use Illuminate\Database\Seeder;

class ThirdBuildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get references
        $rodType = ProductType::where('slug', 'rod')->first();
        $reelType = ProductType::where('slug', 'reel')->first();
        $lineType = ProductType::where('slug', 'line')->first();
        $hookType = ProductType::where('slug', 'hook')->first();
        $lureType = ProductType::where('slug', 'lure')->first();
        $weightType = ProductType::where('slug', 'weight')->first();

        $amazon = Store::where('slug', 'amazon')->first();
        $bassPro = Store::where('slug', 'bass-pro-shops')->first();

        $texasRig = Technique::where('slug', 'texas-rig')->first();
        $smallmouthBass = Species::where('slug', 'smallmouth-bass')->first();

        // Create Texas Rig specific products
        $texasProducts = [];

        // 1. Spinning Rod - Medium
        $texasProducts[] = Product::create([
            'product_type_id' => $rodType->id,
            'name' => 'G. Loomis E6X Spinning Rod 7ft Medium',
            'slug' => 'gloomis-e6x-medium-7ft',
            'brand' => 'G. Loomis',
            'model' => 'E6X',
            'price' => 199.99,
            'description' => 'High-performance graphite rod designed for Texas rig applications. Excellent sensitivity to feel bites and structure.',
            'specifications' => [
                'length' => "7'0\"",
                'power' => 'Medium',
                'action' => 'Fast',
                'line_rating' => '8-17 lb',
                'lure_rating' => '1/4-5/8 oz',
            ],
            'is_active' => true,
            'popularity_score' => 91,
        ]);

        // 2. Spinning Reel
        $texasProducts[] = Product::create([
            'product_type_id' => $reelType->id,
            'name' => 'Daiwa BG 2500 Spinning Reel',
            'slug' => 'daiwa-bg-2500',
            'brand' => 'Daiwa',
            'model' => 'BG 2500',
            'price' => 99.99,
            'description' => 'Durable aluminum body with strong drag system. Perfect for smallmouth bass in rocky environments.',
            'specifications' => [
                'gear_ratio' => '5.6:1',
                'weight' => '9.5 oz',
                'bearings' => '6+1',
                'line_capacity' => '8/240, 10/200',
                'drag' => '22 lbs',
            ],
            'is_active' => true,
            'popularity_score' => 89,
        ]);

        // 3. Fluorocarbon Line
        $texasProducts[] = Product::create([
            'product_type_id' => $lineType->id,
            'name' => 'Sunline Super FC Sniper Fluorocarbon 10lb 200yd',
            'slug' => 'sunline-fc-sniper-10lb',
            'brand' => 'Sunline',
            'model' => 'Super FC Sniper',
            'price' => 27.99,
            'description' => 'Premium fluorocarbon with low visibility and excellent abrasion resistance. Great for rocky smallmouth habitat.',
            'specifications' => [
                'test' => '10 lb',
                'length' => '200 yards',
                'material' => '100% Fluorocarbon',
                'color' => 'Clear',
            ],
            'is_active' => true,
            'popularity_score' => 86,
        ]);

        // 4. Bullet Weights
        $texasProducts[] = Product::create([
            'product_type_id' => $weightType->id,
            'name' => 'Tungsten Bullet Weights 3/8oz (5 pack)',
            'slug' => 'tungsten-bullet-3-8oz',
            'brand' => 'Reins',
            'model' => 'Tungsten Bullet',
            'price' => 9.99,
            'description' => 'Compact tungsten bullet weights for better feel and less snags. Perfect for Texas rigging in rocks.',
            'specifications' => [
                'weight' => '3/8 oz',
                'material' => 'Tungsten',
                'quantity' => '5 pack',
                'color' => 'Green Pumpkin',
            ],
            'is_active' => true,
            'popularity_score' => 84,
        ]);

        // 5. EWG Hooks
        $texasProducts[] = Product::create([
            'product_type_id' => $hookType->id,
            'name' => 'Owner Beast Wide Gap Hook 3/0 (5 pack)',
            'slug' => 'owner-beast-wg-3-0',
            'brand' => 'Owner',
            'model' => 'Beast Wide Gap',
            'price' => 6.99,
            'description' => 'Premium wide gap hooks with sharp points. Perfect for Texas rigging and weedless presentations.',
            'specifications' => [
                'size' => '3/0',
                'style' => 'Extra Wide Gap',
                'quantity' => '5 pack',
                'finish' => 'Black Chrome',
            ],
            'is_active' => true,
            'popularity_score' => 90,
        ]);

        // 6. Soft Plastic - Tubes
        $texasProducts[] = Product::create([
            'product_type_id' => $lureType->id,
            'name' => 'Berkley PowerBait Power Tube 4" - Watermelon',
            'slug' => 'berkley-power-tube-4in',
            'brand' => 'Berkley',
            'model' => 'PowerBait Power Tube',
            'price' => 5.99,
            'description' => 'Classic tube bait that smallmouth bass cannot resist. Scented formula triggers more bites.',
            'specifications' => [
                'length' => '4 inches',
                'color' => 'Watermelon',
                'quantity' => '8 pack',
                'scented' => 'Yes',
            ],
            'is_active' => true,
            'popularity_score' => 88,
        ]);

        // 7. Soft Plastic - Creature Bait
        $texasProducts[] = Product::create([
            'product_type_id' => $lureType->id,
            'name' => 'Strike King Rage Bug - Green Pumpkin',
            'slug' => 'strike-king-rage-bug',
            'brand' => 'Strike King',
            'model' => 'Rage Bug',
            'price' => 4.49,
            'description' => 'Creature bait with flapping appendages. Triggers reaction strikes from aggressive smallmouth.',
            'specifications' => [
                'length' => '4 inches',
                'color' => 'Green Pumpkin',
                'quantity' => '7 pack',
                'action' => 'Flapping',
            ],
            'is_active' => true,
            'popularity_score' => 85,
        ]);

        // Create affiliate links for Texas Rig products
        foreach ($texasProducts as $product) {
            AffiliateLink::create([
                'product_id' => $product->id,
                'store_id' => $amazon->id,
                'affiliate_url' => "https://amazon.com/product/{$product->slug}",
                'price' => $product->price,
                'in_stock' => true,
                'is_active' => true,
            ]);

            AffiliateLink::create([
                'product_id' => $product->id,
                'store_id' => $bassPro->id,
                'affiliate_url' => "https://basspro.com/product/{$product->slug}",
                'price' => $product->price + (rand(5, 20) / 10),
                'in_stock' => true,
                'is_active' => true,
            ]);
        }

        // Create Texas Rig Build for Smallmouth Bass
        $texasBuild = Build::create([
            'technique_id' => $texasRig->id,
            'species_id' => $smallmouthBass->id,
            'name' => 'Texas Rig Setup for Smallmouth Bass - Rocky Terrain',
            'slug' => 'texas-rig-smallmouth-bass-rocks',
            'description' => 'A weedless Texas rig setup optimized for smallmouth bass in rocky environments. This setup excels when fishing around boulders, gravel, and structure where smallmouth love to hide.',
            'budget_tier' => 'intermediate',
            'total_price' => array_sum(array_map(fn($p) => $p->price, $texasProducts)),
            'is_featured' => true,
            'is_active' => true,
            'views_count' => 0,
            'meta_tags' => [
                'title' => 'Texas Rig Setup for Smallmouth Bass | Rocky Terrain Guide',
                'description' => 'Complete Texas rig setup for catching smallmouth bass in rocky areas. Premium gear recommendations for structure fishing.',
                'keywords' => 'texas rig, smallmouth bass, rocky fishing, structure fishing',
            ],
        ]);

        // Attach products to Texas Rig build
        $texasBuild->products()->attach($texasProducts[0]->id, [
            'role' => 'Primary Rod',
            'quantity' => 1,
            'sort_order' => 1,
            'notes' => 'Medium power handles Texas rig weights and provides sensitivity for detecting bites on rocks',
        ]);

        $texasBuild->products()->attach($texasProducts[1]->id, [
            'role' => 'Primary Reel',
            'quantity' => 1,
            'sort_order' => 2,
            'notes' => 'Strong drag system to pull smallmouth out of rocky structure',
        ]);

        $texasBuild->products()->attach($texasProducts[2]->id, [
            'role' => 'Main Line',
            'quantity' => 1,
            'sort_order' => 3,
            'notes' => '10lb fluorocarbon provides stealth and abrasion resistance against rocks',
        ]);

        $texasBuild->products()->attach($texasProducts[3]->id, [
            'role' => 'Bullet Weight',
            'quantity' => 1,
            'sort_order' => 4,
            'notes' => '3/8oz tungsten bullet weight - compact profile navigates rocks better than lead',
        ]);

        $texasBuild->products()->attach($texasProducts[4]->id, [
            'role' => 'Primary Hook',
            'quantity' => 1,
            'sort_order' => 5,
            'notes' => '3/0 wide gap hook for weedless presentations in rocks and structure',
        ]);

        $texasBuild->products()->attach($texasProducts[5]->id, [
            'role' => 'Primary Lure',
            'quantity' => 1,
            'sort_order' => 6,
            'notes' => 'Tube baits are a smallmouth bass classic - deadly around rocks',
        ]);

        $texasBuild->products()->attach($texasProducts[6]->id, [
            'role' => 'Alternative Lure',
            'quantity' => 1,
            'sort_order' => 7,
            'notes' => 'Creature bait alternative when smallmouth want more action and profile',
        ]);

        $this->command->info('✅ Third build created successfully!');
        $this->command->info('🎣 Build 3: Texas Rig for Smallmouth Bass (Rocky Terrain)');
        $this->command->info('📦 Added 7 new products with affiliate links');
    }
}




