@extends('layouts.app')

@section('title', 'FishingGearSetups.com — Complete Fishing Gear Recommendations by Technique and Species')
@section('meta_description', 'Find complete fishing gear setups built for your technique and target species. Compare budget, mid-range, and premium options, then save and share your build with confidence.')

@section('content')
<!-- Hero Section -->
<div class="hero">
    <div class="container-custom" style="text-align: center; max-width: 900px; margin: 0 auto;">
        <h1 class="hero-title">Fishing gear setups that actually work together</h1>
        <p class="hero-subtitle">Explore complete, compatible fishing gear recommendations by technique, target species, and budget tier—then build, save, and shop your setup in minutes.</p>
        <a href="{{ route('techniques.index') }}" class="btn btn-primary" style="margin-top: var(--spacing-lg);">
            Browse Techniques
        </a>
    </div>
</div>

<!-- Featured Builds Section -->
<div class="section" style="background: white;">
    <div class="container-custom">
        <h2 class="section-title">Featured Builds</h2>
        <p class="section-subtitle">
            Complete fishing gear setups recommended by our experts
        </p>

        <!-- Builds Grid -->
        <div class="grid-cards">
            @forelse($featuredBuilds as $build)
                <a href="{{ route('builds.show', $build->slug) }}" class="card" style="text-decoration: none;">
                    @if($build->image_url)
                        <div style="width: 100%; height: 200px; overflow: hidden; background: var(--color-neutral-100);">
                            <img src="{{ $build->image_url }}" alt="{{ $build->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @else
                        <div style="width: 100%; height: 200px; background: linear-gradient(135deg, var(--color-neutral-800) 0%, var(--color-neutral-700) 100%); display: flex; align-items: center; justify-content: center; font-size: 4rem;">
                            🎣
                        </div>
                    @endif
                    
                    <div class="card-content">
                        <div style="display: flex; gap: var(--spacing-xs); margin-bottom: var(--spacing-md); flex-wrap: wrap;">
                            <span class="badge">
                                {{ $build->technique->name }}
                            </span>
                            <span class="badge">
                                {{ $build->species->name }}
                            </span>
                            @if($build->budget_tier)
                                <span class="badge">
                                    {{ ucfirst($build->budget_tier) }}
                                </span>
                            @endif
                        </div>
                        
                        <h3 style="font-size: var(--text-xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-sm);">
                            {{ $build->name }}
                        </h3>
                        
                        @if($build->description)
                            <p class="text-muted line-clamp-2" style="margin-bottom: var(--spacing-md); font-size: var(--text-sm);">
                                {{ $build->description }}
                            </p>
                        @endif
                        
                        <div style="display: flex; align-items: center; justify-content: space-between; padding-top: var(--spacing-md); border-top: 1px solid var(--border-color);">
                            <span style="font-size: var(--text-sm); color: var(--color-neutral-600);">
                                {{ number_format($build->views_count) }} views
                            </span>
                            
                            @if($build->total_price)
                                <span style="font-size: var(--text-xl); font-weight: var(--font-bold); color: var(--color-neutral-900);">
                                    ${{ number_format($build->total_price, 2) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: var(--spacing-3xl);">
                    <div style="font-size: 4rem; margin-bottom: var(--spacing-lg);">🎣</div>
                    <h3 style="font-size: var(--text-2xl); font-weight: var(--font-bold); margin-bottom: var(--spacing-sm);">No Featured Builds Yet</h3>
                    <p class="text-muted">Check back soon for expert-curated gear recommendations</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Techniques Section -->
<div class="section" style="background: var(--color-neutral-50);">
    <div class="container-custom">
        <h2 class="section-title">Fishing Techniques</h2>
        <p class="section-subtitle">
            Explore different fishing methods and get gear recommendations
        </p>

        <div class="grid-cards">
            @foreach($techniques as $technique)
                <a href="{{ route('techniques.show', $technique->slug) }}" class="card" style="text-decoration: none;">
                    <div class="card-content">
                        <h3 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-sm);">
                            {{ $technique->name }}
                        </h3>
                        
                        <p class="text-muted line-clamp-3" style="font-size: var(--text-base);">
                            {{ $technique->description }}
                        </p>
                        
                        <div style="margin-top: var(--spacing-lg);">
                            <span class="text-accent" style="font-weight: var(--font-semibold); font-size: var(--text-sm);">
                                View Builds →
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: var(--spacing-2xl);">
            <a href="{{ route('techniques.index') }}" class="btn btn-outline">
                View All Techniques
            </a>
        </div>
    </div>
</div>

<!-- Target Species Section -->
<div class="section" style="background: white;">
    <div class="container-custom">
        <h2 class="section-title">Target Species</h2>
        <p class="section-subtitle">
            Gear recommendations optimized for your target species
        </p>

        <div class="grid-cards">
            @foreach($species as $specie)
                <a href="{{ route('species.show', $specie->slug) }}" class="card" style="text-decoration: none;">
                    <div class="card-content">
                        <h3 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-xs);">
                            {{ $specie->name }}
                        </h3>
                        
                        @if($specie->scientific_name)
                            <p style="font-size: var(--text-sm); color: var(--color-neutral-500); font-style: italic; margin-bottom: var(--spacing-sm);">
                                {{ $specie->scientific_name }}
                            </p>
                        @endif
                        
                        <p class="text-muted line-clamp-2" style="font-size: var(--text-base);">
                            {{ $specie->description }}
                        </p>
                        
                        <div style="margin-top: var(--spacing-lg);">
                            <span class="text-accent" style="font-weight: var(--font-semibold); font-size: var(--text-sm);">
                                View Builds →
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: var(--spacing-2xl);">
            <a href="{{ route('species.index') }}" class="btn btn-outline">
                View All Species
            </a>
        </div>
    </div>
</div>

<!-- Long-form Homepage Content (SEO) -->
<div class="section" style="background: white;">
    <div class="container-custom">
        <article style="max-width: 900px; margin: 0 auto;">
            <p style="font-size: var(--text-lg); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-xl) 0;">
                Choosing fishing gear should be exciting—not confusing. Yet most anglers end up piecing together a rod, reel, line, terminal tackle, and lures from a dozen different opinions. One person says "medium-heavy everything." Another swears by braid only. Someone else recommends a reel size that doesn't balance your rod, or a lure weight that never loads the blank. The result is a setup that feels awkward, casts poorly, and costs more than it should.
            </p>
            <p style="font-size: var(--text-lg); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-2xl) 0;">
                FishingGearSetups.com fixes that by giving you complete fishing gear setups ("builds") designed around what actually matters: the technique you're fishing, the species you're targeting, and the budget you're comfortable with. Each build shows compatible options (Budget, Mid-Range, Premium), clear gear roles, and straightforward buy links from trusted retailers—so you can stop guessing and start fishing.
            </p>

            <h2 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-lg) 0;">What is FishingGearSetups.com?</h2>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-lg) 0;">
                FishingGearSetups.com is like a PCPartPicker-style platform for fishing tackle. Instead of mixing random "top 10" lists, you browse complete, purpose-built setups that are meant to work together as a system. A build isn't just a rod and reel combo—it's the whole plan: rod power and action matched to the technique, reel size and gear ratio that makes sense, line type and leader choices that fit the cover and clarity, and the right terminal tackle and lure categories for the presentation.
            </p>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-2xl) 0;">
                You also get transparency. You can compare options by budget tier, see what changes (and why), and build your own version by selecting the pieces you prefer. If you want to keep it simple, follow the recommended path. If you want to personalize, you can customize and save your build for later.
            </p>

            <h2 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-lg) 0;">How FishingGearSetups.com Works</h2>
            <ol style="margin: 0 0 var(--spacing-2xl) 1.2rem; padding: 0; color: var(--color-neutral-700); line-height: var(--leading-relaxed);">
                <li style="margin-bottom: var(--spacing-sm);"><strong>Discover</strong> a build by browsing fishing techniques or target species.</li>
                <li style="margin-bottom: var(--spacing-sm);"><strong>Open the build</strong> to view the full gear list organized by role (rod, reel, line, leader, lures, hooks, weights, accessories).</li>
                <li style="margin-bottom: var(--spacing-sm);"><strong>Compare options</strong> using tiered alternatives so you can choose Budget, Mid-Range, or Premium based on your priorities.</li>
                <li style="margin-bottom: var(--spacing-sm);"><strong>Customize your setup</strong> by adding your selected items to your personal build list—then refine until it feels right.</li>
                <li style="margin-bottom: var(--spacing-sm);"><strong>Shop confidently</strong> through retailer links once you’re happy with your selections.</li>
                <li style="margin-bottom: 0;"><strong>Save and share</strong> your build if you want to revisit it, tweak it later, or send it to a fishing buddy.</li>
            </ol>

            <h2 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-lg) 0;">Fishing Gear Builds by Technique</h2>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-lg) 0;">
                Techniques aren’t just “styles”—they’re mechanical requirements. A Carolina Rig asks for different casting feel, line management, and hook-setting leverage than a Drop Shot. That’s why technique-specific gear matters: it’s the difference between feeling the bite and missing it, keeping contact with the bottom or drifting, and staying efficient for an entire day on the water.
            </p>

            <h3 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-sm) 0;">Carolina Rig gear</h3>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-lg) 0;">
                Carolina Rig fishing is about maintaining bottom contact while presenting a bait behind a weight. The right setup prioritizes casting distance, sensitivity, and a rod with enough backbone to drive the hook at the end of a long leader. You’ll typically see build choices that balance weight size, line stretch, and the ability to feel transitions in bottom composition.
            </p>

            <h3 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-sm) 0;">Texas Rig gear</h3>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-lg) 0;">
                Texas Rig fishing often lives in cover—grass, wood, docks, and anywhere bass like to hide. Gear choices lean toward control: accurate casting, confident hook sets, and line that can handle abrasion. The “best” fishing rod and reel combo for a Texas Rig depends on the weight you throw and the cover you fish, which is why tiered options can help you match performance to your home water.
            </p>

            <h3 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-sm) 0;">Drop Shot gear</h3>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-lg) 0;">
                Drop Shotting rewards finesse, sensitivity, and line management. You want a rod that transmits subtle taps, a reel that handles light line smoothly, and a line/leader combination that balances sensitivity with stealth. A good Drop Shot build feels “connected” without overpowering the presentation.
            </p>

            <h3 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-sm) 0;">Ned Rig gear</h3>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-2xl) 0;">
                The Ned Rig is simple, but it’s not “one size fits all.” The right setup makes small jigs cast easily, keeps your bait near the bottom, and helps you detect pressure bites. Builds for Ned Rig fishing typically emphasize light tackle control and consistent hook sets, especially when fishing deeper water or current.
            </p>

            <div style="margin: 0 0 var(--spacing-3xl) 0;">
                <a href="{{ route('techniques.index') }}" class="btn btn-outline">Browse builds by technique</a>
            </div>

            <h2 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-lg) 0;">Fishing Gear Builds by Species</h2>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-lg) 0;">
                Species-based builds help you adapt gear to how fish behave and where they live. Habitat, feeding style, and the way a fish fights all shape smarter equipment choices. A “best fishing setup for bass” often looks different depending on whether you’re targeting largemouth in heavy cover or smallmouth on rocky structure. Walleye may demand a different emphasis entirely, especially when depth control and finesse presentations become the priority.
            </p>

            <h3 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-sm) 0;">Largemouth Bass setups</h3>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-lg) 0;">
                Largemouth Bass often live around vegetation, wood, and shallow ambush points. Gear choices frequently favor power and control—especially when you need to move fish quickly away from cover. Species builds can help you choose lines, hooks, and weights that match the cover and the way you fish a technique.
            </p>

            <h3 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-sm) 0;">Smallmouth Bass setups</h3>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-lg) 0;">
                Smallmouth Bass are often targeted around rock, current seams, and clearer water. That can push your setup toward sensitivity and finesse control so you can feel structure and subtle bites. You’ll often see species builds that put more emphasis on clean line management, leader choice, and a rod action that protects lighter hooks and lines.
            </p>

            <h3 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-sm) 0;">Walleye setups</h3>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-2xl) 0;">
                Walleye fishing often rewards a more deliberate approach—presentations that stay in the strike zone and gear that helps you maintain depth and contact. Whether you’re finesse fishing, drifting, or working structure, a species-focused build helps you align rod feel, line choice, and terminal tackle for consistent hookups.
            </p>

            <div style="margin: 0 0 var(--spacing-3xl) 0;">
                <a href="{{ route('species.index') }}" class="btn btn-outline">Browse builds by species</a>
            </div>

            <h2 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-lg) 0;">Budget-Based Fishing Gear Setups</h2>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-lg) 0;">
                A great fishing gear setup isn’t defined by price—it’s defined by the right tradeoffs for your goals. FishingGearPicker organizes builds across three tiers so you can start where you are and upgrade with a plan, not guesswork. You’ll see what changes from Budget to Mid-Range to Premium, and why those changes matter for your technique and species.
            </p>
            <ul style="margin: 0 0 var(--spacing-2xl) 1.2rem; padding: 0; color: var(--color-neutral-700); line-height: var(--leading-relaxed);">
                <li style="margin-bottom: var(--spacing-sm);"><strong>Budget</strong>: Reliable performance and the essentials done right—perfect for beginner fishing gear or anyone building a new setup without overspending.</li>
                <li style="margin-bottom: var(--spacing-sm);"><strong>Mid-Range</strong>: Upgrades where you feel them most—smoother reels, more sensitive rods, and components that make long days more efficient and enjoyable.</li>
                <li style="margin-bottom: 0;"><strong>Premium</strong>: Refined performance for anglers who want top-tier sensitivity, durability, and technique-specific precision—especially valuable when you fish often or compete.</li>
            </ul>

            <h2 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-lg) 0;">Why Compatibility Matters in Fishing Gear</h2>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-lg) 0;">
                Buying gear one piece at a time can work—until the parts don’t match. Compatibility is what makes a fishing setup feel natural in your hands and predictable in the water. It’s the difference between a cast that loads and launches, and a cast that feels like you’re throwing a brick on a broomstick.
            </p>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-lg) 0;">
                When you’re building a fishing rod and reel combo, start with the technique requirements and then match the system:
            </p>
            <ul style="margin: 0 0 var(--spacing-2xl) 1.2rem; padding: 0; color: var(--color-neutral-700); line-height: var(--leading-relaxed);">
                <li style="margin-bottom: var(--spacing-sm);"><strong>Rod power and action</strong>: These dictate hook-setting leverage, lure control, and whether you can fish efficiently in cover or open water.</li>
                <li style="margin-bottom: var(--spacing-sm);"><strong>Reel size and gear ratio</strong>: This impacts balance, line pickup, and how well you can manage slack on moving baits or bottom contact rigs.</li>
                <li style="margin-bottom: var(--spacing-sm);"><strong>Line type and leader</strong>: Braid, fluorocarbon, and mono each change sensitivity, stretch, abrasion resistance, and visibility.</li>
                <li style="margin-bottom: 0;"><strong>Lure weight and terminal tackle</strong>: Your rod has an optimal range; your weights, hooks, and baits should live inside it for consistent casting and control.</li>
            </ul>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-2xl) 0;">
                FishingGearSetups.com builds are designed around those connections. Instead of "random buying," you follow a coherent system built for performance and confidence.
            </p>

            <h2 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-lg) 0;">Save, Customize and Share Your Builds</h2>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-lg) 0;">
                The best setup is the one that fits your water, your style, and your hands. That's why FishingGearSetups.com lets you customize builds by selecting the products you prefer. As you browse options, you can add items to your personal build list and see your total update.
            </p>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-2xl) 0;">
                Create an account to save your build for later, keep multiple versions (like “spring finesse” and “summer cover”), and share a public link when you want feedback or want to help someone else get started.
            </p>

            <h2 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-lg) 0;">Trusted Affiliate Partners</h2>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-lg) 0;">
                FishingGearSetups.com is supported through affiliate links from retailers like Amazon, Bass Pro Shops, Cabela's, and Tackle Warehouse. If you choose to buy through those links, the retailer may pay a commission. There's no added cost to you, and it helps keep the platform running and improving.
            </p>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-2xl) 0;">
                The philosophy is simple: recommendations come first. Builds are designed to be useful, compatible, and clear—so you can make better decisions whether you buy today or just research for later.
            </p>

            <h2 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-lg) 0;">Who FishingGearSetups.com Is For</h2>
            <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-lg); margin: 0 0 var(--spacing-2xl) 0;">
                <div style="background: var(--color-neutral-50); border: 1px solid var(--border-color); border-radius: var(--border-radius-lg); padding: var(--spacing-lg);">
                    <h3 style="font-size: var(--text-xl); font-weight: var(--font-bold); margin: 0 0 var(--spacing-xs) 0; color: var(--color-neutral-900);">Beginner anglers</h3>
                    <p style="margin: 0; color: var(--color-neutral-700); line-height: var(--leading-relaxed);">
                        Start with beginner fishing gear that covers the essentials. You’ll find builds that remove the guesswork, keep costs under control, and help you learn what each piece does—without getting lost in opinions.
                    </p>
                </div>
                <div style="background: var(--color-neutral-50); border: 1px solid var(--border-color); border-radius: var(--border-radius-lg); padding: var(--spacing-lg);">
                    <h3 style="font-size: var(--text-xl); font-weight: var(--font-bold); margin: 0 0 var(--spacing-xs) 0; color: var(--color-neutral-900);">Intermediate anglers</h3>
                    <p style="margin: 0; color: var(--color-neutral-700); line-height: var(--leading-relaxed);">
                        Add technique-specific setups, refine your line and leader choices, and upgrade where it matters most. Builds make it easy to compare options and understand what you gain from each step up.
                    </p>
                </div>
                <div style="background: var(--color-neutral-50); border: 1px solid var(--border-color); border-radius: var(--border-radius-lg); padding: var(--spacing-lg);">
                    <h3 style="font-size: var(--text-xl); font-weight: var(--font-bold); margin: 0 0 var(--spacing-xs) 0; color: var(--color-neutral-900);">Advanced and expert anglers</h3>
                    <p style="margin: 0; color: var(--color-neutral-700); line-height: var(--leading-relaxed);">
                        Build specialized systems for specific techniques and conditions. Save multiple versions, share with your crew, and use the platform as a fast reference when you’re dialing in gear for the next trip.
                    </p>
                </div>
            </div>

            <h2 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-lg) 0;">The Long-Term Vision</h2>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-lg) 0;">
                FishingGearSetups.com is built to grow into a complete planning tool for anglers. The foundation is already here—clean navigation, product pages, customizable builds, and a structured system for technique and species recommendations. From there, the roadmap expands into deeper guides and more ways to compare and learn.
            </p>
            <ul style="margin: 0 0 var(--spacing-2xl) 1.2rem; padding: 0; color: var(--color-neutral-700); line-height: var(--leading-relaxed);">
                <li style="margin-bottom: var(--spacing-sm);"><strong>More builds</strong> across more techniques, species, and seasonal patterns.</li>
                <li style="margin-bottom: var(--spacing-sm);"><strong>Educational guides</strong> that explain setups, rigs, and why certain gear choices matter.</li>
                <li style="margin-bottom: var(--spacing-sm);"><strong>Comparison features</strong> to help you evaluate options and upgrade paths confidently.</li>
                <li style="margin-bottom: 0;"><strong>Community tools</strong> that make it easier to share builds, discuss tweaks, and learn from other anglers.</li>
            </ul>

            <h2 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin: 0 0 var(--spacing-lg) 0;">Start your first build</h2>
            <p style="font-size: var(--text-base); color: var(--color-neutral-700); line-height: var(--leading-relaxed); margin: 0 0 var(--spacing-lg) 0;">
                Explore a complete fishing gear setup, compare options by budget tier, and choose the pieces you feel confident about. Whether you’re looking for a beginner-friendly bass setup or technique-specific gear for your next trip, you’ll find a clear path forward.
            </p>
            <div style="display: flex; gap: var(--spacing-sm); flex-wrap: wrap; margin: 0 0 var(--spacing-2xl) 0;">
                <a href="{{ route('techniques.index') }}" class="btn btn-primary">Browse Techniques</a>
                <a href="{{ route('species.index') }}" class="btn btn-outline">Browse Species</a>
            </div>
        </article>
    </div>
</div>
@endsection
