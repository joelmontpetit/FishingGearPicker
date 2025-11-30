@extends('layouts.app')

@section('title', $species->name . ' - Fishing Gear Builds')
@section('meta_description', 'Discover the best fishing gear setups for ' . $species->name . '. Expert curated builds with complete equipment recommendations.')

@section('content')
<!-- Breadcrumb -->
<div style="background: var(--color-neutral-50); border-bottom: 1px solid var(--border-color); padding: var(--spacing-md) 0;">
    <div class="container-custom">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="breadcrumb-separator">/</span>
            <a href="{{ route('species.index') }}">Species</a>
            <span class="breadcrumb-separator">/</span>
            <span>{{ $species->name }}</span>
        </nav>
    </div>
</div>

<!-- Header -->
<div style="background: white; padding: var(--spacing-2xl) 0; border-bottom: 1px solid var(--border-color);">
    <div class="container-custom">
        <div style="max-width: 800px;">
            <h1 style="font-size: var(--text-4xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-sm);">
                {{ $species->name }}
            </h1>
            
            @if($species->scientific_name)
                <p style="font-size: var(--text-lg); font-style: italic; color: var(--color-neutral-600); margin-bottom: var(--spacing-lg);">
                    {{ $species->scientific_name }}
                </p>
            @endif
            
            @if($species->description)
                <div style="font-size: var(--text-base); line-height: var(--leading-relaxed); white-space: pre-line; color: var(--color-neutral-700);">
                    {{ $species->description }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Builds Section -->
<div class="section" style="background: white;">
    <div class="container-custom">
        <div style="margin-bottom: var(--spacing-2xl);">
            <h2 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-xs);">
                Recommended Builds for {{ $species->name }}
            </h2>
            <p style="font-size: var(--text-base); color: var(--color-text-tertiary);">
                {{ $builds->count() }} {{ Str::plural('build', $builds->count()) }} available
            </p>
        </div>

        <!-- Builds Grid -->
        <div class="grid-cards">
            @forelse($builds as $build)
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
                    <h3 style="font-size: var(--text-2xl); font-weight: var(--font-bold); margin-bottom: var(--spacing-sm);">No Builds Yet</h3>
                    <p class="text-muted" style="margin-bottom: var(--spacing-lg);">
                        We haven't created any builds for {{ $species->name }} yet
                    </p>
                    <a href="{{ route('species.index') }}" style="color: var(--color-primary); text-decoration: none; font-weight: var(--font-semibold);">
                        ← Browse Other Species
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
