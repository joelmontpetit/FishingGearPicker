@extends('layouts.app')

@section('title', 'All Species - FishingGearPicker')
@section('meta_description', 'Browse all target fish species and discover specialized fishing gear recommendations for each one.')

@section('content')
<!-- Breadcrumb -->
<div style="background: var(--color-neutral-50); border-bottom: 1px solid var(--border-color); padding: var(--spacing-md) 0;">
    <div class="container-custom">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="breadcrumb-separator">/</span>
            <span>Species</span>
        </nav>
    </div>
</div>

<!-- Header -->
<div style="background: white; padding: var(--spacing-2xl) 0; border-bottom: 1px solid var(--border-color);">
    <div class="container-custom">
        <h1 style="font-size: var(--text-4xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-sm);">
            Target Species
        </h1>
        <p class="text-muted" style="font-size: var(--text-lg); max-width: 700px;">
            Explore fishing gear recommendations optimized for specific fish species
        </p>
    </div>
</div>

<!-- Species Grid -->
<div class="section" style="background: white;">
    <div class="container-custom">
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
                        
                        <p class="text-muted line-clamp-3" style="font-size: var(--text-base); margin-bottom: var(--spacing-md);">
                            {{ $specie->description }}
                        </p>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: var(--spacing-md); border-top: 1px solid var(--border-color);">
                            <span class="text-accent" style="font-weight: var(--font-semibold); font-size: var(--text-sm);">
                                View Builds →
                            </span>
                            <span class="badge">
                                {{ $specie->builds_count }} {{ Str::plural('build', $specie->builds_count) }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
