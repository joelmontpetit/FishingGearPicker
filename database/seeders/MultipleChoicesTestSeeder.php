<?php

namespace Database\Seeders;

use App\Models\Build;
use App\Models\BuildProductOption;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MultipleChoicesTestSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first build (Carolina Rig)
        $build = Build::first();
        
        if (!$build) {
            $this->command->error('No build found!');
            return;
        }

        // Get product types
        $rodType = ProductType::where('name', 'like', '%Rod%')->first();
        $reelType = ProductType::where('name', 'like', '%Reel%')->first();
        $lureType = ProductType::where('name', 'like', '%Lure%')->orWhere('name', 'like', '%Soft Plastic%')->first();

        $this->command->info("Adding multiple product options to build: {$build->name}");

        // Create alternative RODS
        $budgetRod = Product::firstOrCreate(
            ['slug' => 'ugly-stik-gx2-casting-rod-7'],
            [
                'name' => 'Ugly Stik GX2 Casting Rod 7\'',
                'brand' => 'Ugly Stik',
                'model' => 'GX2',
                'description' => 'Legendary durability meets modern performance. Great starter rod for Carolina rigging.',
                'price' => 49.99,
                'product_type_id' => $rodType?->id,
                'is_active' => true,
            ]
        );

        $premiumRod = Product::firstOrCreate(
            ['slug' => 'st-croix-legend-x-casting-rod'],
            [
                'name' => 'St. Croix Legend X Casting Rod 7\'2"',
                'brand' => 'St. Croix',
                'model' => 'Legend X',
                'description' => 'Premium American-made rod with incredible sensitivity and power for serious anglers.',
                'price' => 320.00,
                'product_type_id' => $rodType?->id,
                'is_active' => true,
            ]
        );

        // Create alternative REELS
        $budgetReel = Product::firstOrCreate(
            ['slug' => 'abu-garcia-black-max-low-profile'],
            [
                'name' => 'Abu Garcia Black Max Low Profile',
                'brand' => 'Abu Garcia',
                'model' => 'Black Max',
                'description' => 'Affordable baitcaster with MagTrax brake system. Perfect for beginners.',
                'price' => 59.99,
                'product_type_id' => $reelType?->id,
                'is_active' => true,
            ]
        );

        $premiumReel = Product::firstOrCreate(
            ['slug' => 'shimano-metanium-mgl'],
            [
                'name' => 'Shimano Metanium MGL',
                'brand' => 'Shimano',
                'model' => 'Metanium MGL',
                'description' => 'Ultra-lightweight magnesium body with silky smooth drag. Tournament-grade performance.',
                'price' => 449.99,
                'product_type_id' => $reelType?->id,
                'is_active' => true,
            ]
        );

        // Create alternative LURES (multiple mid-tier options)
        $lure1 = Product::firstOrCreate(
            ['slug' => 'zoom-brush-hog-6'],
            [
                'name' => 'Zoom Brush Hog 6"',
                'brand' => 'Zoom',
                'model' => 'Brush Hog',
                'description' => 'Classic creature bait with multiple appendages for maximum water displacement.',
                'price' => 5.99,
                'product_type_id' => $lureType?->id,
                'is_active' => true,
            ]
        );

        $lure2 = Product::firstOrCreate(
            ['slug' => 'strike-king-rage-bug'],
            [
                'name' => 'Strike King Rage Bug',
                'brand' => 'Strike King',
                'model' => 'Rage Bug',
                'description' => 'Unique claw design creates incredible action. Great for Carolina rigs.',
                'price' => 6.49,
                'product_type_id' => $lureType?->id,
                'is_active' => true,
            ]
        );

        $lure3 = Product::firstOrCreate(
            ['slug' => 'berkley-powerbait-maxscent-creature-hawg'],
            [
                'name' => 'Berkley PowerBait MaxScent Creature Hawg',
                'brand' => 'Berkley',
                'model' => 'MaxScent Creature Hawg',
                'description' => 'Scent-infused soft plastic that fish hold onto longer. Perfect for finicky bass.',
                'price' => 7.99,
                'product_type_id' => $lureType?->id,
                'is_active' => true,
            ]
        );

        $budgetLure = Product::firstOrCreate(
            ['slug' => 'yum-dinger-5'],
            [
                'name' => 'YUM Dinger 5"',
                'brand' => 'YUM',
                'model' => 'Dinger',
                'description' => 'Budget-friendly Senko-style bait. Great action at a fraction of the price.',
                'price' => 3.99,
                'product_type_id' => $lureType?->id,
                'is_active' => true,
            ]
        );

        $premiumLure = Product::firstOrCreate(
            ['slug' => 'yamamoto-senko-5-30-pack'],
            [
                'name' => 'Yamamoto Senko 5" (30 pack)',
                'brand' => 'Gary Yamamoto',
                'model' => 'Senko',
                'description' => 'The original and still the best. Salt-impregnated for perfect fall rate.',
                'price' => 24.99,
                'product_type_id' => $lureType?->id,
                'is_active' => true,
            ]
        );

        // Add budget and premium options for Rod
        BuildProductOption::firstOrCreate(
            ['build_id' => $build->id, 'product_id' => $budgetRod->id, 'role' => 'Primary Rod'],
            [
                'price_tier' => 'budget',
                'sort_order' => 0,
                'is_recommended' => false,
                'notes' => 'Great value rod for beginners. Nearly indestructible.',
            ]
        );

        BuildProductOption::firstOrCreate(
            ['build_id' => $build->id, 'product_id' => $premiumRod->id, 'role' => 'Primary Rod'],
            [
                'price_tier' => 'premium',
                'sort_order' => 2,
                'is_recommended' => false,
                'notes' => 'Top-tier sensitivity for detecting subtle bites.',
            ]
        );

        // Update existing rod to be mid-tier recommended
        BuildProductOption::where('build_id', $build->id)
            ->where('role', 'Primary Rod')
            ->where('price_tier', 'mid')
            ->update(['is_recommended' => true, 'sort_order' => 1]);

        // Add budget and premium options for Reel
        BuildProductOption::firstOrCreate(
            ['build_id' => $build->id, 'product_id' => $budgetReel->id, 'role' => 'Primary Reel'],
            [
                'price_tier' => 'budget',
                'sort_order' => 0,
                'is_recommended' => false,
                'notes' => 'Solid budget baitcaster. Good for learning.',
            ]
        );

        BuildProductOption::firstOrCreate(
            ['build_id' => $build->id, 'product_id' => $premiumReel->id, 'role' => 'Primary Reel'],
            [
                'price_tier' => 'premium',
                'sort_order' => 2,
                'is_recommended' => false,
                'notes' => 'Featherweight with buttery smooth operation.',
            ]
        );

        // Update existing reel to be mid-tier recommended
        BuildProductOption::where('build_id', $build->id)
            ->where('role', 'Primary Reel')
            ->where('price_tier', 'mid')
            ->update(['is_recommended' => true, 'sort_order' => 1]);

        // Add MULTIPLE mid-tier lure options (this is what the user wants!)
        BuildProductOption::firstOrCreate(
            ['build_id' => $build->id, 'product_id' => $lure1->id, 'role' => 'Primary Lure'],
            [
                'price_tier' => 'mid',
                'sort_order' => 1,
                'is_recommended' => false,
                'notes' => 'Classic creature bait - works in any water clarity.',
            ]
        );

        BuildProductOption::firstOrCreate(
            ['build_id' => $build->id, 'product_id' => $lure2->id, 'role' => 'Primary Lure'],
            [
                'price_tier' => 'mid',
                'sort_order' => 2,
                'is_recommended' => false,
                'notes' => 'Unique action that triggers reaction strikes.',
            ]
        );

        BuildProductOption::firstOrCreate(
            ['build_id' => $build->id, 'product_id' => $lure3->id, 'role' => 'Primary Lure'],
            [
                'price_tier' => 'mid',
                'sort_order' => 3,
                'is_recommended' => false,
                'notes' => 'Scent technology keeps fish biting longer.',
            ]
        );

        // Add budget and premium lure options
        BuildProductOption::firstOrCreate(
            ['build_id' => $build->id, 'product_id' => $budgetLure->id, 'role' => 'Primary Lure'],
            [
                'price_tier' => 'budget',
                'sort_order' => 0,
                'is_recommended' => false,
                'notes' => 'Best value stick bait on the market.',
            ]
        );

        BuildProductOption::firstOrCreate(
            ['build_id' => $build->id, 'product_id' => $premiumLure->id, 'role' => 'Primary Lure'],
            [
                'price_tier' => 'premium',
                'sort_order' => 4,
                'is_recommended' => false,
                'notes' => 'The gold standard - nothing falls like a Senko.',
            ]
        );

        // Update existing lure to be mid-tier recommended
        BuildProductOption::where('build_id', $build->id)
            ->where('role', 'Primary Lure')
            ->where('price_tier', 'mid')
            ->where(function($q) {
                $q->whereNull('notes')->orWhere('notes', '');
            })
            ->update(['is_recommended' => true, 'sort_order' => 0]);

        $this->command->info('✅ Added multiple product options:');
        $this->command->info('   - 3 Rod options (Budget, Mid, Premium)');
        $this->command->info('   - 3 Reel options (Budget, Mid, Premium)');
        $this->command->info('   - 5 Lure options (1 Budget, 3 Mid, 1 Premium)');
        $this->command->info('');
        $this->command->info('🎣 Visit /builds/' . $build->slug . ' to see the carousel!');
    }
}

