@extends('layouts.app')

@section('title', $build->meta_tags['title'] ?? $build->name . ' | FishingGearPicker')
@section('meta_description', $build->meta_tags['description'] ?? $build->description)
@section('meta_keywords', $build->meta_tags['keywords'] ?? '')

@section('content')
<div x-data="buildPage()">
<!-- Breadcrumb -->
<div style="background: var(--color-neutral-50); border-bottom: 1px solid var(--border-color); padding: var(--spacing-md) 0;">
    <div class="container-custom">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="breadcrumb-separator">/</span>
            <a href="{{ route('techniques.index') }}">Techniques</a>
            <span class="breadcrumb-separator">/</span>
            <a href="{{ route('techniques.show', $build->technique->slug) }}">{{ $build->technique->name }}</a>
            <span class="breadcrumb-separator">/</span>
            <span>{{ $build->name }}</span>
        </nav>
    </div>
</div>

<!-- Build Header -->
<div style="background: white; padding: var(--spacing-2xl) 0; border-bottom: 1px solid var(--border-color); overflow-x: hidden;">
    <div class="container-custom" style="overflow-x: hidden;">
        <div style="display: flex; gap: var(--spacing-xs); margin-bottom: var(--spacing-lg); flex-wrap: wrap;">
            <span class="badge">
                {{ $build->technique->name }}
            </span>
            <span class="badge">
                {{ $build->species->name }}
            </span>
            <span class="badge">
                {{ ucfirst($build->budget_tier) }} Budget
            </span>
            @if($build->is_featured)
                <span class="badge">
                    ⭐ Featured
                </span>
            @endif
        </div>

        <h1 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-md); word-wrap: break-word;">
            {{ $build->name }}
        </h1>

        <p style="font-size: var(--text-base); color: var(--color-neutral-700); margin-bottom: var(--spacing-xl); line-height: var(--leading-relaxed); word-wrap: break-word;">
            {{ $build->description }}
        </p>

        <div style="display: flex; align-items: center; justify-content: space-between; padding-top: var(--spacing-lg); border-top: 1px solid var(--border-color); flex-wrap: wrap; gap: var(--spacing-md);">
            <div style="display: flex; align-items: center; color: var(--color-neutral-600); font-size: var(--text-sm);">
                <svg style="width: 20px; height: 20px; margin-right: var(--spacing-xs); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                {{ number_format($build->views_count) }} views
            </div>

            <div style="display: flex; align-items: center; gap: var(--spacing-md); flex-wrap: wrap;">
                @if($build->total_price)
                    <div style="text-align: right;">
                        <p style="font-size: var(--text-sm); color: var(--color-neutral-600); margin-bottom: var(--spacing-xs);">Total Price</p>
                        <p style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900);">${{ number_format($build->total_price, 2) }}</p>
                    </div>
                @endif

                @auth
                    <button 
                        @click="showSaveModal = true"
                        class="btn"
                        style="display: flex; align-items: center; gap: var(--spacing-xs);">
                        <svg style="width: 20px; height: 20px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        Save Build
                    </button>
                @else
                    <a href="{{ route('login') }}" class="btn" style="display: flex; align-items: center; gap: var(--spacing-xs);">
                        <svg style="width: 20px; height: 20px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        Login to Save
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Products Section -->
<div class="section" style="background: var(--color-neutral-50); overflow-x: hidden;">
    <div class="container-custom" style="overflow-x: hidden;">
        <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-2xl); max-width: 100%; overflow-x: hidden;" class="build-layout">
            <!-- Main Content - Product List -->
            <div>
                <h2 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-2xl);">
                    Complete Gear List
                </h2>

                <div style="display: flex; flex-direction: column; gap: var(--spacing-xl);">
                    @php
                        // Group products by role
                        $productsByRole = $build->productOptions->sortBy('sort_order')->groupBy('role');
                    @endphp

            @foreach($productsByRole as $role => $options)
                @php
                    $optionsArray = $options->values();
                    $optionCount = $optionsArray->count();
                    $tiers = $options->pluck('price_tier')->unique()->values();
                    $hasTiers = $tiers->count() > 1;
                @endphp
                
                <div class="card" style="overflow: hidden; width: 100%; box-sizing: border-box;" x-data="productCarousel({{ $optionCount }}, '{{ $role }}', {{ json_encode($optionsArray->map(fn($o) => ['id' => $o->product_id, 'name' => $o->product->name, 'price' => $o->product->price ?? 0, 'tier' => $o->price_tier])) }})">
                    <!-- Role Header -->
                    <div style="padding: 12px; border-bottom: 1px solid #e5e5e5; background: #fafafa; overflow: hidden;">
                        <div style="margin-bottom: 8px;">
                            <span class="badge" style="font-size: 11px; padding: 2px 8px;">
                                {{ ucfirst($role) }}
                            </span>
                        </div>
                        <h3 style="font-size: 16px; font-weight: 700; color: #171717; margin: 0 0 8px 0;">
                            Choose Your {{ ucfirst($role) }}
                        </h3>

                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <!-- Price Tier Filter (only show if multiple tiers exist) -->
                            @if($hasTiers)
                                <div style="display: flex; gap: 2px; background: white; padding: 3px; border-radius: 6px; border: 1px solid #e5e5e5; flex-wrap: wrap;">
                                    <button 
                                        @click="filterTier = null; currentIndex = 0"
                                        :class="filterTier === null ? 'active' : ''"
                                        class="tier-tab"
                                        style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; border: none; cursor: pointer;">
                                        All
                                    </button>
                                    @foreach($tiers as $tier)
                                        <button 
                                            @click="filterTier = '{{ $tier }}'; currentIndex = 0"
                                            :class="filterTier === '{{ $tier }}' ? 'active' : ''"
                                            class="tier-tab"
                                            style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; border: none; cursor: pointer;">
                                            @if($tier === 'budget')
                                                💰
                                            @elseif($tier === 'mid')
                                                💎
                                            @elseif($tier === 'premium')
                                                ⭐
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Option Counter & Navigation -->
                            @if($optionCount > 1)
                                <div style="display: flex; align-items: center; gap: 4px;">
                                    <button 
                                        @click="prev()"
                                        :disabled="currentIndex === 0"
                                        class="carousel-nav-btn"
                                        style="width: 28px; height: 28px;"
                                        :style="currentIndex === 0 ? 'opacity: 0.3; cursor: not-allowed;' : ''">
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <span style="font-size: 12px; font-weight: 600; color: #404040; min-width: 40px; text-align: center;">
                                        <span x-text="currentIndex + 1"></span>/<span x-text="filteredCount"></span>
                                    </span>
                                    <button 
                                        @click="next()"
                                        :disabled="currentIndex >= filteredCount - 1"
                                        class="carousel-nav-btn"
                                        style="width: 28px; height: 28px;"
                                        :style="currentIndex >= filteredCount - 1 ? 'opacity: 0.3; cursor: not-allowed;' : ''">
                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Product Carousel -->
                    <div style="position: relative; overflow: hidden;">
                        @foreach($optionsArray as $index => $option)
                            @php $product = $option->product; @endphp
                            
                            <div x-show="shouldShowOption({{ $index }}, '{{ $option->price_tier }}')" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform translate-x-4"
                                 x-transition:enter-end="opacity-100 transform translate-x-0"
                                 style="padding: 16px; overflow: hidden;">
                                
                                <div style="display: block;" class="product-carousel-item">
                                    <!-- Product Image -->
                                    <div style="width: 120px; height: 120px; margin-bottom: 12px;">
                                        @if($product->image_url)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                        @else
                                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #e5e5e5 0%, #d4d4d4 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">
                                                🎣
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div style="width: 100%; overflow: hidden;">
                                        <div style="display: flex; gap: 4px; flex-wrap: wrap; margin-bottom: 8px;">
                                            @if($option->is_recommended)
                                                <span class="badge" style="background: #171717; color: white; font-size: 11px; padding: 2px 8px;">
                                                    ⭐ Recommended
                                                </span>
                                            @endif
                                            <span class="badge" style="font-size: 11px; padding: 2px 8px;">
                                                @if($option->price_tier === 'budget')
                                                    💰 Budget
                                                @elseif($option->price_tier === 'mid')
                                                    💎 Mid-Range
                                                @elseif($option->price_tier === 'premium')
                                                    ⭐ Premium
                                                @endif
                                            </span>
                                        </div>
                                        
                                        <h4 style="font-size: 18px; font-weight: 700; color: #171717; margin: 0 0 4px 0; word-wrap: break-word; overflow-wrap: break-word;">
                                            <a href="{{ route('products.show', $product->slug) }}" style="color: #171717; text-decoration: none;">
                                                {{ $product->name }}
                                            </a>
                                        </h4>
                                        <p style="font-size: 13px; color: #525252; margin: 0 0 8px 0;">
                                            {{ $product->brand }} {{ $product->model ? '- ' . $product->model : '' }}
                                        </p>
                                        
                                        @if($product->price)
                                            <p style="font-size: 20px; font-weight: 700; color: #171717; margin: 0 0 12px 0;">
                                                ${{ number_format($product->price, 2) }}
                                            </p>
                                        @endif

                                        @if($product->description)
                                            <p style="font-size: 14px; color: #525252; margin: 0 0 12px 0; line-height: 1.5; word-wrap: break-word; overflow-wrap: break-word;">
                                                {{ $product->description }}
                                            </p>
                                        @endif

                                        @if($option->notes)
                                            <div style="background: #fafafa; padding: 12px; border-radius: 8px; margin-bottom: 12px; border-left: 3px solid #171717;">
                                                <p style="font-size: 13px; font-weight: 600; color: #171717; margin: 0 0 4px 0;">
                                                    Why This Product:
                                                </p>
                                                <p style="font-size: 13px; color: #404040; margin: 0; word-wrap: break-word;">
                                                    {{ $option->notes }}
                                                </p>
                                            </div>
                                        @endif

                                        <!-- Action Buttons -->
                                        <div style="display: flex; gap: 8px; flex-wrap: wrap; padding-top: 12px; border-top: 1px solid #e5e5e5;">
                                            <!-- Add to Build Button -->
                                            <button 
                                                @click="$dispatch('add-to-build', { 
                                                    id: {{ $product->id }}, 
                                                    name: '{{ addslashes($product->name) }}', 
                                                    price: {{ $product->price ?? 0 }},
                                                    role: '{{ $role }}',
                                                    image: '{{ $product->image_url ?? '' }}',
                                                    brand: '{{ addslashes($product->brand ?? '') }}'
                                                })"
                                                class="btn add-to-build-btn"
                                                style="background: #171717; color: white; display: flex; align-items: center; gap: 4px; padding: 8px 12px; font-size: 13px;">
                                                <svg style="width: 16px; height: 16px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                Add to Build
                                            </button>

                                            <!-- Affiliate Links -->
                                            @if($product->affiliateLinks->isNotEmpty())
                                                @foreach($product->affiliateLinks->where('is_active', true) as $link)
                                                    <a href="{{ $link->affiliate_url }}" target="_blank" rel="nofollow noopener" class="btn" style="font-size: 12px; padding: 8px 12px; white-space: nowrap;">
                                                        {{ $link->store->name }} 
                                                        @if($link->price)
                                                            ${{ number_format($link->price, 2) }}
                                                        @endif
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Dots indicator for mobile -->
                    @if($optionCount > 1)
                        <div style="display: flex; justify-content: center; gap: var(--spacing-xs); padding: var(--spacing-md); border-top: 1px solid var(--border-color);">
                            <template x-for="i in filteredCount" :key="i">
                                <button 
                                    @click="currentIndex = i - 1"
                                    :class="currentIndex === i - 1 ? 'dot-active' : ''"
                                    class="carousel-dot"
                                    style="width: 10px; height: 10px; border-radius: 50%; border: none; cursor: pointer; transition: all var(--transition-fast);">
                                </button>
                            </template>
                        </div>
                    @endif
                </div>
            @endforeach
                </div>
            </div>

            <!-- Sidebar - Your Build -->
            <div class="your-build-sidebar">
                <div class="card">
                    <!-- Header - Clickable on mobile to expand/collapse -->
                    <div 
                        @click="sidebarExpanded = !sidebarExpanded"
                        style="padding: var(--spacing-lg); border-bottom: 1px solid var(--border-color); background: var(--color-neutral-900); color: white; cursor: pointer;"
                        class="build-sidebar-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h3 style="font-size: var(--text-xl); font-weight: var(--font-bold); display: flex; align-items: center; gap: var(--spacing-sm);">
                                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Your Build
                                    <span x-show="buildItems.length > 0" style="background: white; color: var(--color-neutral-900); font-size: var(--text-xs); padding: 2px 8px; border-radius: 999px; margin-left: var(--spacing-xs);" x-text="buildItems.length"></span>
                                </h3>
                                <p style="font-size: 14px; opacity: 0.8; margin-top: 4px;">
                                    <span x-text="buildItems.length"></span> item<span x-show="buildItems.length !== 1">s</span> · 
                                    <span x-text="'$' + (buildTotal || 0).toFixed(2)"></span>
                                </p>
                            </div>
                            <!-- Expand/Collapse arrow (mobile only) -->
                            <div class="mobile-expand-arrow">
                                <svg :style="sidebarExpanded ? 'transform: rotate(180deg)' : ''" style="width: 24px; height: 24px; transition: transform 0.2s;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Collapsible Content (on mobile) -->
                    <div class="build-sidebar-content" :class="{ 'expanded': sidebarExpanded }">
                        <!-- Empty State -->
                        <div x-show="buildItems.length === 0" style="padding: var(--spacing-xl); text-align: center;">
                            <div style="font-size: 3rem; margin-bottom: var(--spacing-md);">🎣</div>
                            <p style="color: var(--color-neutral-600); font-size: var(--text-sm);">
                                Click "Add to Build" on products to start building your custom gear list.
                            </p>
                        </div>

                        <!-- Build Items List -->
                        <div x-show="buildItems.length > 0" class="build-items-list">
                            <template x-for="(item, index) in buildItems" :key="item.id + '-' + index">
                                <div style="padding: var(--spacing-md); border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; gap: var(--spacing-sm);">
                                    <div style="flex: 1; min-width: 0;">
                                        <p style="font-size: var(--text-xs); color: var(--color-neutral-500); text-transform: uppercase; letter-spacing: 0.05em;" x-text="item.role"></p>
                                        <p style="font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-neutral-900); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" x-text="item.name"></p>
                                        <p style="font-size: var(--text-sm); color: var(--color-neutral-700);" x-text="'$' + parseFloat(item.price).toFixed(2)"></p>
                                    </div>
                                    <button 
                                        @click.stop="removeFromBuild(index)"
                                        style="padding: var(--spacing-xs); background: none; border: none; cursor: pointer; color: var(--color-neutral-400); transition: color var(--transition-fast);"
                                        onmouseover="this.style.color='#dc2626'"
                                        onmouseout="this.style.color='var(--color-neutral-400)'">
                                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <!-- Total & Actions -->
                        <div x-show="buildItems.length > 0" class="build-actions-footer">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <span style="font-size: 14px; font-weight: 600; color: #374151;">Total:</span>
                                <span style="font-size: 20px; font-weight: 700; color: #111827;" x-text="'$' + (buildTotal || 0).toFixed(2)"></span>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                                @auth
                                    <button 
                                        @click.stop="showSaveModal = true"
                                        class="btn"
                                        style="width: 100%; background: var(--color-neutral-900); color: white; justify-content: center;">
                                        <svg style="width: 18px; height: 18px; margin-right: var(--spacing-xs);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                        </svg>
                                        Save Build
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="btn" style="width: 100%; background: var(--color-neutral-900); color: white; justify-content: center; text-decoration: none;">
                                        <svg style="width: 18px; height: 18px; margin-right: var(--spacing-xs);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                        Login to Save
                                    </a>
                                @endauth

                                <button 
                                    @click.stop="clearBuild()"
                                    class="btn"
                                    style="width: 100%; background: white; color: var(--color-neutral-700); border: 1px solid var(--border-color); justify-content: center;">
                                    Clear All
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Save Build Modal -->
@auth
<div x-show="showSaveModal" 
     x-cloak
     @click.self="showSaveModal = false"
     style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000; padding: var(--spacing-md);">
    <div @click.stop 
         style="background: white; border-radius: var(--border-radius-lg); max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: var(--shadow-xl);">
        
        <!-- Modal Header -->
        <div style="padding: var(--spacing-xl); border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900);">
                Save Your Custom Build
            </h3>
            <button @click="showSaveModal = false" style="padding: var(--spacing-xs); background: none; border: none; cursor: pointer; color: var(--color-neutral-500); transition: color var(--transition-fast);" onmouseover="this.style.color='var(--color-neutral-900)'" onmouseout="this.style.color='var(--color-neutral-500)'">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <form @submit.prevent="saveBuild" style="padding: var(--spacing-xl);">
            <div style="display: flex; flex-direction: column; gap: var(--spacing-lg);">
                <!-- Build Name -->
                <div>
                    <label style="display: block; font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-neutral-900); margin-bottom: var(--spacing-xs);">
                        Build Name <span style="color: var(--color-neutral-500);">*</span>
                    </label>
                    <input 
                        type="text" 
                        x-model="saveForm.name"
                        required
                        placeholder="e.g., My Carolina Rig Setup"
                        style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--border-color); border-radius: var(--border-radius-md); font-size: var(--text-base);">
                </div>

                <!-- Description -->
                <div>
                    <label style="display: block; font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-neutral-900); margin-bottom: var(--spacing-xs);">
                        Notes (Optional)
                    </label>
                    <textarea 
                        x-model="saveForm.description"
                        rows="3"
                        placeholder="Add any notes about your build choices..."
                        style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--border-color); border-radius: var(--border-radius-md); font-size: var(--text-base); resize: vertical;"></textarea>
                </div>

                <!-- Public/Private -->
                <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                    <input 
                        type="checkbox" 
                        x-model="saveForm.is_public"
                        id="is_public"
                        style="width: 20px; height: 20px; cursor: pointer;">
                    <label for="is_public" style="font-size: var(--text-sm); color: var(--color-neutral-700); cursor: pointer;">
                        Make this build public (others can view it)
                    </label>
                </div>

                <!-- Selected Products Summary -->
                <div style="background: var(--color-neutral-50); padding: var(--spacing-md); border-radius: var(--border-radius-md); border: 1px solid var(--border-color);">
                    <h4 style="font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-neutral-900); margin-bottom: var(--spacing-sm);">
                        Your Build (<span x-text="buildItems.length"></span> items):
                    </h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: var(--spacing-xs); max-height: 200px; overflow-y: auto;">
                        <template x-for="(item, index) in buildItems" :key="item.id + '-' + index">
                            <li style="font-size: var(--text-sm); color: var(--color-neutral-700); display: flex; justify-content: space-between;">
                                <span>
                                    <span style="color: var(--color-neutral-500);" x-text="item.role + ':'"></span>
                                    <span x-text="item.name"></span>
                                </span>
                                <span style="font-weight: var(--font-semibold);" x-text="'$' + item.price.toFixed(2)"></span>
                            </li>
                        </template>
                    </ul>
                    <div style="margin-top: var(--spacing-md); padding-top: var(--spacing-md); border-top: 1px solid var(--border-color);">
                        <span style="font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-neutral-900);">Total Price: </span>
                        <span style="font-size: var(--text-lg); font-weight: var(--font-bold); color: var(--color-neutral-900);" x-text="'$' + buildTotal.toFixed(2)"></span>
                    </div>
                </div>

                <!-- Error Message -->
                <div x-show="saveError" style="background: #fee2e2; border: 1px solid #dc2626; border-radius: var(--border-radius-md); padding: var(--spacing-md);">
                    <p style="font-size: var(--text-sm); color: #dc2626;" x-text="saveError"></p>
                </div>

                <!-- Success Message -->
                <div x-show="saveSuccess" style="background: #d1fae5; border: 1px solid #10b981; border-radius: var(--border-radius-md); padding: var(--spacing-md);">
                    <p style="font-size: var(--text-sm); color: #10b981;">Build saved successfully!</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div style="display: flex; justify-content: flex-end; gap: var(--spacing-sm); margin-top: var(--spacing-xl); padding-top: var(--spacing-lg); border-top: 1px solid var(--border-color);">
                <button 
                    type="button"
                    @click="showSaveModal = false"
                    class="btn"
                    style="background: var(--color-neutral-200); color: var(--color-neutral-700);">
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="btn"
                    :disabled="saving"
                    style="background: var(--color-neutral-900); color: white;">
                    <span x-show="!saving">Save Build</span>
                    <span x-show="saving">Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endauth
</div>

<style>
    /* Build Layout - Desktop: 2 columns, Mobile: 1 column */
    @media (min-width: 1024px) {
        .build-layout {
            grid-template-columns: 1fr 350px !important;
        }
        
        .your-build-sidebar .card {
            position: sticky;
            top: var(--spacing-lg);
        }
    }

    @media (min-width: 768px) {
        .product-carousel-item {
            grid-template-columns: 150px 1fr !important;
        }
    }

    /* Mobile: Floating cart bar */
    @media (max-width: 1023px) {
        /* Prevent horizontal overflow */
        .build-layout,
        .card,
        .product-carousel-item {
            max-width: 100%;
            overflow-x: hidden;
        }
        
        .your-build-sidebar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 100;
            margin: 0;
            padding: 0;
        }
        
        .your-build-sidebar .card {
            border-radius: 16px 16px 0 0;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.15);
            overflow: hidden;
            background: white;
        }
        
        .build-sidebar-header {
            border-radius: 16px 16px 0 0 !important;
        }
        
        .build-sidebar-content {
            display: none;
        }
        
        .build-sidebar-content.expanded {
            display: block;
            max-height: 50vh;
            overflow-y: auto;
        }
        
        .build-items-list {
            max-height: 120px;
            overflow-y: auto;
        }
        
        .build-actions-footer {
            padding: 12px 16px;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
        }
        
        .mobile-expand-arrow {
            display: block;
        }
        
        /* Add bottom padding to main content so it's not hidden behind cart */
        .build-layout > div:first-child {
            padding-bottom: 100px !important;
        }
        
        /* Extra space at bottom of page */
        .section {
            padding-bottom: 100px !important;
        }
        
        /* Fix card width on mobile */
        .card {
            width: 100% !important;
            box-sizing: border-box;
        }
    }
    
    /* Desktop: Always show content, hide expand arrow */
    @media (min-width: 1024px) {
        .build-sidebar-header {
            cursor: default !important;
            border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
        }
        
        .build-sidebar-content {
            max-height: none !important;
            overflow: visible !important;
        }
        
        .build-items-list {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .build-actions-footer {
            padding: var(--spacing-lg);
            background: var(--color-neutral-50);
        }
        
        .mobile-expand-arrow {
            display: none;
        }
    }

    .tier-tab {
        background: white;
        color: var(--color-neutral-600);
    }

    .tier-tab:hover {
        background: var(--color-neutral-100);
        color: var(--color-neutral-900);
    }

    .tier-tab.active {
        background: var(--color-neutral-900);
        color: white;
    }

    .carousel-nav-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 1px solid var(--border-color);
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all var(--transition-fast);
        color: var(--color-neutral-700);
    }

    .carousel-nav-btn:hover:not(:disabled) {
        background: var(--color-neutral-900);
        color: white;
        border-color: var(--color-neutral-900);
    }

    .carousel-dot {
        background: var(--color-neutral-300);
    }

    .carousel-dot:hover {
        background: var(--color-neutral-500);
    }

    .carousel-dot.dot-active {
        background: var(--color-neutral-900);
    }

    .add-to-build-btn {
        transition: all var(--transition-fast);
    }

    .add-to-build-btn:hover {
        transform: scale(1.02);
        box-shadow: var(--shadow-md);
    }

    /* Toast notification */
    .toast-notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: white;
        padding: var(--spacing-md) var(--spacing-lg);
        border-radius: var(--border-radius-md);
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        z-index: 1001;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
    }

    .toast-notification.show {
        transform: translateY(0);
        opacity: 1;
    }

    .toast-notification span {
        font-size: var(--text-sm);
        font-weight: var(--font-semibold);
        color: var(--color-neutral-900);
    }

    [x-cloak] {
        display: none !important;
    }
</style>

<script>
    function buildPage() {
        return {
            // Carousel state per role
            carousels: {},
            
            // Save modal state
            showSaveModal: false,
            saving: false,
            saveError: '',
            saveSuccess: false,
            
            // Save form data
            saveForm: {
                name: '{{ $build->name }} - Custom',
                description: '',
                is_public: false,
                original_build_id: {{ $build->id }}
            },

            // Build items (multiple products can be added)
            buildItems: [],
            
            // Sidebar expanded state (mobile)
            sidebarExpanded: false,
            
            // Selected products (tracking user's choices) - legacy
            selectedProducts: {},
            totalPrice: 0,

            get buildTotal() {
                return this.buildItems.reduce((sum, item) => sum + (parseFloat(item.price) || 0), 0);
            },

            init() {
                // Expose instance globally for carousel components
                window.buildPageInstance = this;
                
                // Listen for add-to-build events
                this.$el.addEventListener('add-to-build', (event) => {
                    this.addToBuild(event.detail);
                });
                
                // Load from localStorage if available
                this.loadFromStorage();
            },

            addToBuild(product) {
                // Add product to build items
                this.buildItems.push({
                    id: product.id,
                    name: product.name,
                    price: product.price || 0,
                    role: product.role,
                    image: product.image || '',
                    brand: product.brand || ''
                });
                
                // Save to localStorage
                this.saveToStorage();
                
                // Open sidebar on mobile
                this.sidebarExpanded = true;
                
                // Show feedback
                this.showAddedFeedback(product.name);
            },

            removeFromBuild(index) {
                this.buildItems.splice(index, 1);
                this.saveToStorage();
            },

            clearBuild() {
                if (confirm('Are you sure you want to clear all items from your build?')) {
                    this.buildItems = [];
                    this.saveToStorage();
                }
            },

            saveToStorage() {
                const storageKey = 'build_{{ $build->id }}_items';
                localStorage.setItem(storageKey, JSON.stringify(this.buildItems));
            },

            loadFromStorage() {
                const storageKey = 'build_{{ $build->id }}_items';
                const saved = localStorage.getItem(storageKey);
                if (saved) {
                    try {
                        this.buildItems = JSON.parse(saved);
                    } catch (e) {
                        this.buildItems = [];
                    }
                }
            },

            showAddedFeedback(productName) {
                // Create toast notification
                const toast = document.createElement('div');
                toast.className = 'toast-notification';
                toast.innerHTML = `
                    <svg style="width: 20px; height: 20px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Added to build!</span>
                `;
                document.body.appendChild(toast);
                
                // Animate in
                setTimeout(() => toast.classList.add('show'), 10);
                
                // Remove after delay
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => toast.remove(), 300);
                }, 2000);
            },

            initializeSelections() {
                const productsByRole = @json($build->productOptions->groupBy('role'));
                
                for (const [role, options] of Object.entries(productsByRole)) {
                    // Find recommended or first option
                    const recommended = options.find(opt => opt.is_recommended);
                    const defaultOption = recommended || options[0];
                    
                    if (defaultOption) {
                        this.selectedProducts[role] = {
                            product_id: defaultOption.product_id,
                            role: role,
                            name: defaultOption.product.name,
                            price: defaultOption.product.price || 0,
                            quantity: 1
                        };
                    }
                }
                
                this.calculateTotalPrice();
            },

            selectProduct(role, product, tierIndex) {
                this.selectedProducts[role] = {
                    product_id: product.id,
                    role: role,
                    name: product.name,
                    price: product.price || 0,
                    quantity: 1
                };
                this.calculateTotalPrice();
            },

            calculateTotalPrice() {
                this.totalPrice = Object.values(this.selectedProducts).reduce((sum, product) => {
                    return sum + (product.price * product.quantity);
                }, 0);
            },

            async saveBuild() {
                this.saving = true;
                this.saveError = '';
                this.saveSuccess = false;

                // Prepare products data from buildItems
                const products = this.buildItems.map(item => ({
                    product_id: item.id,
                    role: item.role,
                    quantity: 1,
                    notes: null
                }));

                if (products.length === 0) {
                    this.saveError = 'Please add at least one product to your build.';
                    this.saving = false;
                    return;
                }

                try {
                    const response = await fetch('{{ route('profile.builds.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            ...this.saveForm,
                            products: products
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        this.saveSuccess = true;
                        // Clear localStorage after successful save
                        localStorage.removeItem('build_{{ $build->id }}_items');
                        setTimeout(() => {
                            window.location.href = data.redirect_url;
                        }, 1000);
                    } else {
                        this.saveError = data.message || 'Failed to save build. Please try again.';
                    }
                } catch (error) {
                    this.saveError = 'An error occurred. Please try again.';
                    console.error('Save build error:', error);
                } finally {
                    this.saving = false;
                }
            }
        }
    }

    function productCarousel(totalOptions, role, optionsData) {
        return {
            currentIndex: 0,
            filterTier: null,
            totalOptions: totalOptions,
            role: role,
            optionsData: optionsData,
            
            get filteredOptions() {
                if (this.filterTier === null) {
                    return this.optionsData;
                }
                return this.optionsData.filter(opt => opt.tier === this.filterTier);
            },
            
            get filteredCount() {
                return this.filteredOptions.length;
            },
            
            shouldShowOption(index, tier) {
                if (this.filterTier !== null && tier !== this.filterTier) {
                    return false;
                }
                
                // Get the filtered index
                const filteredIndices = this.optionsData
                    .map((opt, i) => ({ index: i, tier: opt.tier }))
                    .filter(opt => this.filterTier === null || opt.tier === this.filterTier)
                    .map(opt => opt.index);
                
                return filteredIndices[this.currentIndex] === index;
            },
            
            next() {
                if (this.currentIndex < this.filteredCount - 1) {
                    this.currentIndex++;
                    this.updateSelection();
                }
            },
            
            prev() {
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                    this.updateSelection();
                }
            },
            
            updateSelection() {
                // Update the parent buildPage's selected products
                const currentOption = this.filteredOptions[this.currentIndex];
                if (currentOption && window.buildPageInstance) {
                    window.buildPageInstance.selectProduct(this.role, currentOption);
                }
            }
        }
    }
</script>
@endsection
