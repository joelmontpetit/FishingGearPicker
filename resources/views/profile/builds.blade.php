@extends('layouts.app')

@section('title', 'My Saved Builds | FishingGearPicker')

@section('content')
<!-- Breadcrumb -->
<div style="background: var(--color-neutral-50); border-bottom: 1px solid var(--border-color); padding: var(--spacing-md) 0;">
    <div class="container-custom">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="breadcrumb-separator">/</span>
            <a href="{{ route('profile.edit') }}">Profile</a>
            <span class="breadcrumb-separator">/</span>
            <span>My Builds</span>
        </nav>
    </div>
</div>

<!-- Page Header -->
<div style="background: white; padding: var(--spacing-2xl) 0; border-bottom: 1px solid var(--border-color);">
    <div class="container-custom">
        <h1 style="font-size: var(--text-4xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-md);">
            My Saved Builds
        </h1>
        <p style="font-size: var(--text-lg); color: var(--color-neutral-700); line-height: var(--leading-relaxed);">
            View and manage your customized fishing gear builds
        </p>
    </div>
</div>

<!-- Builds Grid -->
<div class="section" style="background: var(--color-neutral-50);">
    <div class="container-custom">
        @if($savedBuilds->isEmpty())
            <div class="card" style="text-align: center; padding: var(--spacing-3xl);">
                <svg style="width: 64px; height: 64px; margin: 0 auto var(--spacing-md); color: var(--color-neutral-400);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
                <h2 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-md);">
                    No Saved Builds Yet
                </h2>
                <p style="font-size: var(--text-base); color: var(--color-neutral-600); margin-bottom: var(--spacing-xl); max-width: 500px; margin-left: auto; margin-right: auto;">
                    Start by browsing our techniques and builds, then save your custom configurations for future reference.
                </p>
                <a href="{{ route('techniques.index') }}" class="btn" style="display: inline-flex; align-items: center; gap: var(--spacing-xs);">
                    Browse Techniques
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        @else
            <div class="grid-cards">
                @foreach($savedBuilds as $savedBuild)
                    <div class="card">
                        <div style="padding: var(--spacing-lg);">
                            <!-- Build Header -->
                            <div style="display: flex; gap: var(--spacing-xs); margin-bottom: var(--spacing-md); flex-wrap: wrap;">
                                <span class="badge">
                                    {{ $savedBuild->originalBuild->technique->name }}
                                </span>
                                <span class="badge">
                                    {{ $savedBuild->originalBuild->species->name }}
                                </span>
                                @if($savedBuild->is_public)
                                    <span class="badge" style="background: var(--color-neutral-900); color: white;">
                                        Public
                                    </span>
                                @else
                                    <span class="badge">
                                        Private
                                    </span>
                                @endif
                            </div>

                            <!-- Build Title -->
                            <h3 style="font-size: var(--text-xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-sm);">
                                <a href="{{ route('profile.builds.show', $savedBuild->slug) }}" style="color: var(--color-neutral-900); text-decoration: none; transition: color var(--transition-fast);" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color='var(--color-neutral-900)'">
                                    {{ $savedBuild->name }}
                                </a>
                            </h3>

                            @if($savedBuild->description)
                                <p style="font-size: var(--text-sm); color: var(--color-neutral-600); margin-bottom: var(--spacing-md); line-height: var(--leading-relaxed);">
                                    {{ Str::limit($savedBuild->description, 100) }}
                                </p>
                            @endif

                            <!-- Build Stats -->
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: var(--spacing-md); border-top: 1px solid var(--border-color); flex-wrap: wrap; gap: var(--spacing-sm);">
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: var(--text-xs); color: var(--color-neutral-600);">Total Price</span>
                                    <span style="font-size: var(--text-lg); font-weight: var(--font-bold); color: var(--color-neutral-900);">
                                        ${{ number_format($savedBuild->total_price, 2) }}
                                    </span>
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: var(--text-xs); color: var(--color-neutral-600);">Products</span>
                                    <span style="font-size: var(--text-lg); font-weight: var(--font-bold); color: var(--color-neutral-900);">
                                        {{ $savedBuild->products->count() }}
                                    </span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div style="display: flex; gap: var(--spacing-sm); margin-top: var(--spacing-md);">
                                <a href="{{ route('profile.builds.show', $savedBuild->slug) }}" class="btn" style="flex: 1; text-align: center;">
                                    View Build
                                </a>
                                <form action="{{ route('profile.builds.destroy', $savedBuild->slug) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this build?');" style="flex: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="background: #dc2626; color: white; padding: var(--spacing-sm) var(--spacing-md);">
                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($savedBuilds->hasPages())
                <div style="margin-top: var(--spacing-2xl);">
                    {{ $savedBuilds->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection



