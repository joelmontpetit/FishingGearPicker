@extends('layouts.app')

@section('title', 'FishingGearPicker - Complete Fishing Gear Recommendations')
@section('meta_description', 'Discover curated fishing gear setups for any technique and species. Expert recommendations with affiliate links from top retailers.')

@section('content')
<!-- Hero Section -->
<div class="hero">
    <div class="container-custom" style="text-align: center; max-width: 900px; margin: 0 auto;">
        <h1 class="hero-title">
            Find Your Perfect Fishing Setup
        </h1>
        <p class="hero-subtitle">
            Expert-curated fishing gear recommendations by technique, species, and budget.
        </p>
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
@endsection
