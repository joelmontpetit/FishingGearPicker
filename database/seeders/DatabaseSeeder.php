<?php

namespace Database\Seeders;

use App\Models\AffiliateLink;
use App\Models\Build;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Species;
use App\Models\Store;
use App\Models\Technique;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@fishinggear.com',
        ]);

        // Create Product Types
        $productTypes = [
            ['name' => 'Rod', 'slug' => 'rod', 'description' => 'Fishing rods of various lengths and actions'],
            ['name' => 'Reel', 'slug' => 'reel', 'description' => 'Spinning, baitcasting, and other reel types'],
            ['name' => 'Line', 'slug' => 'line', 'description' => 'Fishing line - monofilament, fluorocarbon, braided'],
            ['name' => 'Hook', 'slug' => 'hook', 'description' => 'Various hook styles and sizes'],
            ['name' => 'Lure', 'slug' => 'lure', 'description' => 'Artificial lures and baits'],
            ['name' => 'Weight', 'slug' => 'weight', 'description' => 'Sinkers and weights for rigging'],
            ['name' => 'Accessory', 'slug' => 'accessory', 'description' => 'Swivels, snaps, and other tackle accessories'],
        ];

        foreach ($productTypes as $type) {
            ProductType::create($type);
        }

        // Create Stores
        $stores = [
            ['name' => 'Amazon', 'slug' => 'amazon', 'website_url' => 'https://amazon.com'],
            ['name' => 'Bass Pro Shops', 'slug' => 'bass-pro-shops', 'website_url' => 'https://basspro.com'],
            ['name' => "Cabela's", 'slug' => 'cabelas', 'website_url' => 'https://cabelas.com'],
            ['name' => 'Tackle Warehouse', 'slug' => 'tackle-warehouse', 'website_url' => 'https://tacklewarehouse.com'],
        ];

        foreach ($stores as $store) {
            Store::create($store);
        }

        // Create Techniques
        $techniques = [
            [
                'name' => 'Carolina Rig',
                'slug' => 'carolina-rig',
                'description' => 'A popular bottom-fishing technique using a sliding sinker setup. Excellent for covering water and finding bass on structure.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Drop Shot',
                'slug' => 'drop-shot',
                'description' => 'A finesse technique with the weight below the hook, allowing the bait to suspend off the bottom.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Texas Rig',
                'slug' => 'texas-rig',
                'description' => 'A weedless rigging method using a bullet weight and offset hook, perfect for fishing in heavy cover.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Ned Rig',
                'slug' => 'ned-rig',
                'description' => 'A finesse technique using a mushroom-style jig head with a buoyant soft plastic. Deadly for pressured fish and great for walleye.',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($techniques as $technique) {
            Technique::create($technique);
        }

        // Create Species
        $species = [
            [
                'name' => 'Largemouth Bass',
                'slug' => 'largemouth-bass',
                'scientific_name' => 'Micropterus salmoides',
                'description' => 'The most popular freshwater game fish in North America. Known for aggressive strikes and acrobatic fights.',
                'habitat_info' => ['water_type' => 'freshwater', 'preferred_temp' => '65-75°F', 'cover' => 'vegetation, structure'],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Smallmouth Bass',
                'slug' => 'smallmouth-bass',
                'scientific_name' => 'Micropterus dolomieu',
                'description' => 'Known as the "bronze back", smallmouth are prized for their fighting ability.',
                'habitat_info' => ['water_type' => 'freshwater', 'preferred_temp' => '60-70°F', 'cover' => 'rocks, gravel'],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Walleye',
                'slug' => 'walleye',
                'scientific_name' => 'Sander vitreus',
                'description' => "The Walleye is one of the most sought-after freshwater game fish in North America. Known for its excellent vision in low-light conditions, the Walleye is highly active at dawn, dusk, and in deeper or murky waters.\n\nCommonly found in lakes, rivers, rocky structures, weedlines, and drop-offs, the Walleye prefers cooler water and often holds near points, ledges, and underwater transitions.",
                'habitat_info' => ['water_type' => 'freshwater', 'preferred_temp' => '55-68°F', 'cover' => 'rocks, ledges, points'],
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($species as $spec) {
            Species::create($spec);
        }

        // Get references
        $rodType = ProductType::where('slug', 'rod')->first();
        $reelType = ProductType::where('slug', 'reel')->first();
        $lineType = ProductType::where('slug', 'line')->first();
        $hookType = ProductType::where('slug', 'hook')->first();
        $lureType = ProductType::where('slug', 'lure')->first();
        $weightType = ProductType::where('slug', 'weight')->first();
        $swivel = ProductType::where('slug', 'accessory')->first();

        $amazon = Store::where('slug', 'amazon')->first();
        $bassPro = Store::where('slug', 'bass-pro-shops')->first();

        // Create Products for Carolina Rig Build
        $products = [
            // Rod
            [
                'product_type_id' => $rodType->id,
                'name' => 'Ugly Stik GX2 Medium Heavy 7ft Spinning Rod',
                'slug' => 'ugly-stik-gx2-mh-7ft',
                'brand' => 'Ugly Stik',
                'model' => 'GX2',
                'price' => 49.99,
                'description' => 'Durable graphite and fiberglass composite rod. Perfect for Carolina rigging with medium-heavy power and fast action.',
                'specifications' => [
                    'length' => "7'0\"",
                    'power' => 'Medium Heavy',
                    'action' => 'Fast',
                    'line_rating' => '10-20 lb',
                    'lure_rating' => '1/4-3/4 oz',
                ],
                'is_active' => true,
                'popularity_score' => 95,
            ],
            // Reel
            [
                'product_type_id' => $reelType->id,
                'name' => 'PENN Battle III 3000 Spinning Reel',
                'slug' => 'penn-battle-iii-3000',
                'brand' => 'PENN',
                'model' => 'Battle III 3000',
                'price' => 79.95,
                'description' => 'Full metal body and sideplate. Smooth drag system ideal for Carolina rig presentations.',
                'specifications' => [
                    'gear_ratio' => '6.2:1',
                    'bearings' => '5+1',
                    'line_capacity' => '10/200, 12/170',
                    'retrieve_rate' => '35 inches',
                ],
                'is_active' => true,
                'popularity_score' => 90,
            ],
            // Main Line
            [
                'product_type_id' => $lineType->id,
                'name' => 'PowerPro Spectra Braided Line 15lb 300yds',
                'slug' => 'powerpro-braid-15lb',
                'brand' => 'PowerPro',
                'model' => 'Spectra Fiber',
                'price' => 24.99,
                'description' => 'Low-stretch braided line for excellent sensitivity. Perfect as main line for Carolina rigs.',
                'specifications' => [
                    'test' => '15 lb',
                    'length' => '300 yards',
                    'color' => 'Moss Green',
                    'material' => 'Spectra Fiber',
                ],
                'is_active' => true,
                'popularity_score' => 85,
            ],
            // Leader Line
            [
                'product_type_id' => $lineType->id,
                'name' => 'Seaguar Red Label Fluorocarbon 12lb 200yds',
                'slug' => 'seaguar-red-label-12lb',
                'brand' => 'Seaguar',
                'model' => 'Red Label',
                'price' => 19.99,
                'description' => 'Invisible fluorocarbon leader. Low visibility and excellent abrasion resistance.',
                'specifications' => [
                    'test' => '12 lb',
                    'length' => '200 yards',
                    'material' => '100% Fluorocarbon',
                ],
                'is_active' => true,
                'popularity_score' => 88,
            ],
            // Weight
            [
                'product_type_id' => $weightType->id,
                'name' => 'Bullet Weights Tungsten Carolina Rig Weight 3/4oz',
                'slug' => 'tungsten-carolina-weight-3-4oz',
                'brand' => 'Bullet Weights',
                'model' => 'Tungsten Carolina',
                'price' => 6.99,
                'description' => 'High-density tungsten weight. Creates better feel and smaller profile than lead.',
                'specifications' => [
                    'weight' => '3/4 oz',
                    'material' => 'Tungsten',
                    'color' => 'Black',
                ],
                'is_active' => true,
                'popularity_score' => 80,
            ],
            // Hook
            [
                'product_type_id' => $hookType->id,
                'name' => 'Gamakatsu EWG Offset Worm Hook 4/0 - 6 pack',
                'slug' => 'gamakatsu-ewg-4-0',
                'brand' => 'Gamakatsu',
                'model' => 'EWG Offset',
                'price' => 5.49,
                'description' => 'Extra wide gap offset hook. Perfect for Texas-rigging soft plastics on Carolina rigs.',
                'specifications' => [
                    'size' => '4/0',
                    'style' => 'Offset Worm',
                    'quantity' => '6 pack',
                    'finish' => 'Black Nickel',
                ],
                'is_active' => true,
                'popularity_score' => 92,
            ],
            // Soft Plastic Lure
            [
                'product_type_id' => $lureType->id,
                'name' => 'Zoom Super Fluke - Watermelon Seed',
                'slug' => 'zoom-super-fluke-watermelon',
                'brand' => 'Zoom',
                'model' => 'Super Fluke',
                'price' => 4.99,
                'description' => 'Versatile soft plastic bait. Classic profile that bass can\'t resist on a Carolina rig.',
                'specifications' => [
                    'length' => '5 inches',
                    'color' => 'Watermelon Seed',
                    'quantity' => '10 pack',
                ],
                'is_active' => true,
                'popularity_score' => 87,
            ],
            // Swivel
            [
                'product_type_id' => $swivel->id,
                'name' => 'SPRO Power Swivels Size 6 - 10 pack',
                'slug' => 'spro-power-swivel-6',
                'brand' => 'SPRO',
                'model' => 'Power Swivel',
                'price' => 4.29,
                'description' => 'Premium ball bearing swivel. Prevents line twist on Carolina rigs.',
                'specifications' => [
                    'size' => '6',
                    'test' => '65 lb',
                    'quantity' => '10 pack',
                ],
                'is_active' => true,
                'popularity_score' => 75,
            ],
        ];

        $createdProducts = [];
        foreach ($products as $productData) {
            $product = Product::create($productData);
            $createdProducts[] = $product;

            // Add affiliate links for each product
            AffiliateLink::create([
                'product_id' => $product->id,
                'store_id' => $amazon->id,
                'affiliate_url' => 'https://amazon.com/product/' . $product->slug,
                'price' => $product->price,
                'in_stock' => true,
                'is_active' => true,
            ]);

            AffiliateLink::create([
                'product_id' => $product->id,
                'store_id' => $bassPro->id,
                'affiliate_url' => 'https://basspro.com/product/' . $product->slug,
                'price' => $product->price * 1.05, // Slightly higher price
                'in_stock' => true,
                'is_active' => true,
            ]);
        }

        // Create Carolina Rig Build for Largemouth Bass
        $carolinaRig = Technique::where('slug', 'carolina-rig')->first();
        $largemouthBass = Species::where('slug', 'largemouth-bass')->first();

        $build = Build::create([
            'technique_id' => $carolinaRig->id,
            'species_id' => $largemouthBass->id,
            'name' => 'Carolina Rig Setup for Largemouth Bass - Beginner',
            'slug' => 'carolina-rig-largemouth-bass-beginner',
            'description' => 'A complete beginner-friendly Carolina rig setup perfect for targeting largemouth bass in various conditions. This setup offers excellent sensitivity and the ability to cover water efficiently while keeping your bait in the strike zone.',
            'budget_tier' => 'beginner',
            'total_price' => array_sum(array_column($products, 'price')),
            'is_featured' => true,
            'is_active' => true,
            'meta_tags' => [
                'title' => 'Complete Carolina Rig Setup for Bass Fishing | Beginner Guide',
                'description' => 'Learn the perfect Carolina rig setup for largemouth bass. Complete gear list with rod, reel, line, and tackle recommendations.',
                'keywords' => 'carolina rig, bass fishing, fishing setup, largemouth bass',
            ],
        ]);

        // Attach products to build with roles
        $build->products()->attach($createdProducts[0]->id, [
            'role' => 'Primary Rod',
            'quantity' => 1,
            'sort_order' => 1,
            'notes' => 'Medium-heavy power handles Carolina rig weights and provides good hooksets',
        ]);

        $build->products()->attach($createdProducts[1]->id, [
            'role' => 'Primary Reel',
            'quantity' => 1,
            'sort_order' => 2,
            'notes' => 'Smooth drag and good line capacity for long casts',
        ]);

        $build->products()->attach($createdProducts[2]->id, [
            'role' => 'Main Line',
            'quantity' => 1,
            'sort_order' => 3,
            'notes' => 'Braided main line provides zero stretch for maximum sensitivity',
        ]);

        $build->products()->attach($createdProducts[3]->id, [
            'role' => 'Leader Line',
            'quantity' => 1,
            'sort_order' => 4,
            'notes' => 'Fluorocarbon leader (2-4 feet) is invisible to fish and abrasion resistant',
        ]);

        $build->products()->attach($createdProducts[4]->id, [
            'role' => 'Carolina Weight',
            'quantity' => 1,
            'sort_order' => 5,
            'notes' => '3/4oz tungsten weight slides above the swivel',
        ]);

        $build->products()->attach($createdProducts[5]->id, [
            'role' => 'Primary Hook',
            'quantity' => 1,
            'sort_order' => 6,
            'notes' => '4/0 EWG hook perfect for rigging soft plastics weedless',
        ]);

        $build->products()->attach($createdProducts[6]->id, [
            'role' => 'Primary Lure',
            'quantity' => 1,
            'sort_order' => 7,
            'notes' => 'Classic soft plastic that produces bites year-round',
        ]);

        $build->products()->attach($createdProducts[7]->id, [
            'role' => 'Swivel',
            'quantity' => 1,
            'sort_order' => 8,
            'notes' => 'Connects main line to leader and prevents line twist',
        ]);

        // ===================================================
        // NED RIG BUILD FOR WALLEYE
        // ===================================================

        $nedRig = Technique::where('slug', 'ned-rig')->first();
        $walleye = Species::where('slug', 'walleye')->first();

        // Create Ned Rig specific products
        $nedProducts = [];

        // 1. Spinning Rod - Medium Light
        $nedProducts[] = Product::create([
            'product_type_id' => $rodType->id,
            'name' => 'St. Croix Triumph Spinning Rod 7ft Medium Light',
            'slug' => 'st-croix-triumph-ml-7ft',
            'brand' => 'St. Croix',
            'model' => 'Triumph',
            'price' => 129.99,
            'description' => 'Premium graphite rod with medium-light power perfect for finesse presentations. Excellent sensitivity for detecting subtle walleye bites.',
            'specifications' => [
                'length' => "7'0\"",
                'power' => 'Medium Light',
                'action' => 'Fast',
                'line_rating' => '6-10 lb',
                'lure_rating' => '1/16-3/8 oz',
            ],
            'is_active' => true,
            'popularity_score' => 88,
        ]);

        // 2. Spinning Reel
        $nedProducts[] = Product::create([
            'product_type_id' => $reelType->id,
            'name' => 'Shimano Stradic CI4+ 2500 Spinning Reel',
            'slug' => 'shimano-stradic-ci4-2500',
            'brand' => 'Shimano',
            'model' => 'Stradic CI4+ 2500',
            'price' => 189.99,
            'description' => 'Lightweight and smooth spinning reel. Excellent drag system for fighting walleye. Perfect for finesse techniques.',
            'specifications' => [
                'gear_ratio' => '6.0:1',
                'weight' => '6.7 oz',
                'bearings' => '6+1',
                'line_capacity' => '6/200, 8/140, 10/120',
                'drag' => '20 lbs',
            ],
            'is_active' => true,
            'popularity_score' => 92,
        ]);

        // 3. Braided Line
        $nedProducts[] = Product::create([
            'product_type_id' => $lineType->id,
            'name' => 'PowerPro Spectra Fiber Braided Line 10lb 300yd',
            'slug' => 'powerpro-10lb-300yd',
            'brand' => 'PowerPro',
            'model' => 'Spectra Fiber',
            'price' => 24.99,
            'description' => 'Ultra-thin braided line with excellent sensitivity. No stretch for better hooksets on walleye.',
            'specifications' => [
                'test' => '10 lb',
                'diameter' => '0.008 in',
                'length' => '300 yards',
                'color' => 'Moss Green',
            ],
            'is_active' => true,
            'popularity_score' => 90,
        ]);

        // 4. Fluorocarbon Leader
        $nedProducts[] = Product::create([
            'product_type_id' => $lineType->id,
            'name' => 'Seaguar InvizX Fluorocarbon 8lb 200yd',
            'slug' => 'seaguar-invizx-8lb',
            'brand' => 'Seaguar',
            'model' => 'InvizX',
            'price' => 21.99,
            'description' => 'Virtually invisible fluorocarbon leader. Ideal for clear water walleye fishing.',
            'specifications' => [
                'test' => '8 lb',
                'length' => '200 yards',
                'material' => '100% Fluorocarbon',
            ],
            'is_active' => true,
            'popularity_score' => 87,
        ]);

        // 5. Ned Rig Jig Heads
        $nedProducts[] = Product::create([
            'product_type_id' => $hookType->id,
            'name' => 'Z-Man Finesse ShroomZ Jig Heads 1/6oz (5 pack)',
            'slug' => 'zman-shroomz-1-6oz',
            'brand' => 'Z-Man',
            'model' => 'Finesse ShroomZ',
            'price' => 5.99,
            'description' => 'Mushroom-shaped jig head designed specifically for Ned Rig fishing. Keeps bait standing up off bottom.',
            'specifications' => [
                'weight' => '1/6 oz',
                'hook_size' => '#1',
                'quantity' => '5 pack',
                'hook_type' => 'Mushroom Jig',
            ],
            'is_active' => true,
            'popularity_score' => 95,
        ]);

        // 6. Ned Rig Soft Plastics
        $nedProducts[] = Product::create([
            'product_type_id' => $lureType->id,
            'name' => 'Z-Man TRD (The Real Deal) 10 pack',
            'slug' => 'zman-trd-10pack',
            'brand' => 'Z-Man',
            'model' => 'TRD',
            'price' => 6.99,
            'description' => 'Buoyant ElaZtech plastic designed for Ned Rig. Stands up naturally and attracts walleye bites.',
            'specifications' => [
                'length' => '2.75 in',
                'quantity' => '10 pack',
                'material' => 'ElaZtech (Buoyant)',
                'colors' => 'Green Pumpkin',
            ],
            'is_active' => true,
            'popularity_score' => 93,
        ]);

        // Create affiliate links for Ned Rig products
        foreach ($nedProducts as $index => $product) {
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
                'price' => $product->price + (rand(5, 15) / 10),
                'in_stock' => true,
                'is_active' => true,
            ]);
        }

        // Create Ned Rig Build for Walleye
        $nedBuild = Build::create([
            'technique_id' => $nedRig->id,
            'species_id' => $walleye->id,
            'name' => 'Ned Rig Setup for Walleye - Finesse',
            'slug' => 'ned-rig-walleye-finesse',
            'description' => 'A finesse Ned Rig setup perfect for pressured walleye in clear water. The subtle presentation and buoyant plastic triggers bites when other techniques fail.',
            'budget_tier' => 'intermediate',
            'total_price' => array_sum(array_column($nedProducts, 'price')),
            'is_featured' => false,
            'is_active' => true,
            'views_count' => 0,
        ]);

        // Attach products to Ned Rig build
        $nedBuild->products()->attach($nedProducts[0]->id, [
            'role' => 'Primary Rod',
            'quantity' => 1,
            'sort_order' => 1,
            'notes' => 'Medium-light power provides perfect action for Ned Rig presentations',
        ]);

        $nedBuild->products()->attach($nedProducts[1]->id, [
            'role' => 'Primary Reel',
            'quantity' => 1,
            'sort_order' => 2,
            'notes' => 'Smooth drag and lightweight design perfect for finesse fishing',
        ]);

        $nedBuild->products()->attach($nedProducts[2]->id, [
            'role' => 'Main Line',
            'quantity' => 1,
            'sort_order' => 3,
            'notes' => '10lb braided main line for maximum sensitivity',
        ]);

        $nedBuild->products()->attach($nedProducts[3]->id, [
            'role' => 'Leader',
            'quantity' => 1,
            'sort_order' => 4,
            'notes' => '8lb fluorocarbon leader (6-8ft) for stealth in clear water',
        ]);

        $nedBuild->products()->attach($nedProducts[4]->id, [
            'role' => 'Jig Head',
            'quantity' => 1,
            'sort_order' => 5,
            'notes' => 'Mushroom-style jig head keeps plastic standing upright',
        ]);

        $nedBuild->products()->attach($nedProducts[5]->id, [
            'role' => 'Primary Lure',
            'quantity' => 1,
            'sort_order' => 6,
            'notes' => 'Buoyant ElaZtech plastic creates natural presentation',
        ]);

        // Seed SEO Metas
        $this->call(SeoMetaSeeder::class);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📦 Created: 4 Techniques, 3 Species, 2 Builds, 14 Products');
        $this->command->info('🏪 Created: 4 Stores with affiliate links');
        $this->command->info('🎣 Build 1: Carolina Rig for Largemouth Bass (Beginner)');
        $this->command->info('🎣 Build 2: Ned Rig for Walleye (Finesse/Intermediate)');
    }
}
