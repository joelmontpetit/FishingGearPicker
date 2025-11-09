@extends('layouts.app')

@section('title', $build->meta_tags['title'] ?? $build->name . ' | FishingGearPicker')
@section('meta_description', $build->meta_tags['description'] ?? $build->description)
@section('meta_keywords', $build->meta_tags['keywords'] ?? '')

@section('content')
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
<div style="background: white; padding: var(--spacing-2xl) 0; border-bottom: 1px solid var(--border-color);">
    <div class="container-custom">
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

        <h1 style="font-size: var(--text-4xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-md); max-width: 900px;">
            {{ $build->name }}
        </h1>

        <p style="font-size: var(--text-lg); color: var(--color-neutral-700); margin-bottom: var(--spacing-xl); max-width: 800px; line-height: var(--leading-relaxed);">
            {{ $build->description }}
        </p>

        <div style="display: flex; align-items: center; justify-content: space-between; padding-top: var(--spacing-lg); border-top: 1px solid var(--border-color); flex-wrap: wrap; gap: var(--spacing-md);">
            <div style="display: flex; align-items: center; color: var(--color-neutral-600); font-size: var(--text-sm);">
                <svg style="width: 20px; height: 20px; margin-right: var(--spacing-xs);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                {{ number_format($build->views_count) }} views
            </div>

            @if($build->total_price)
                <div style="text-align: right;">
                    <p style="font-size: var(--text-sm); color: var(--color-neutral-600); margin-bottom: var(--spacing-xs);">Total Price</p>
                    <p style="font-size: var(--text-4xl); font-weight: var(--font-bold); color: var(--color-neutral-900);">${{ number_format($build->total_price, 2) }}</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Products Section -->
<div class="section" style="background: var(--color-neutral-50);">
    <div class="container-custom">
        <h2 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-2xl);">
            Complete Gear List
        </h2>

        <div style="display: flex; flex-direction: column; gap: var(--spacing-xl);">
            @foreach($build->products as $product)
                <div class="card">
                    <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-lg); padding: var(--spacing-xl);">
                        <!-- Product Image -->
                        <div style="width: 100%; max-width: 150px;">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 150px; object-fit: cover; border-radius: var(--border-radius-md);">
                            @else
                                <div style="width: 100%; height: 150px; background: linear-gradient(135deg, var(--color-neutral-200) 0%, var(--color-neutral-300) 100%); border-radius: var(--border-radius-md); display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                                    🎣
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--spacing-sm); flex-wrap: wrap; gap: var(--spacing-sm);">
                                <div>
                                    <span class="badge" style="margin-bottom: var(--spacing-xs);">
                                        {{ $product->pivot->role ?? $product->productType->name }}
                                    </span>
                                    <h3 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-top: var(--spacing-xs);">
                                        <a href="{{ route('products.show', $product->slug) }}" style="color: var(--color-neutral-900); text-decoration: none; transition: color var(--transition-fast);" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color='var(--color-neutral-900)'">
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    <p style="font-size: var(--text-sm); color: var(--color-neutral-600); margin-top: var(--spacing-xs);">
                                        {{ $product->brand }} {{ $product->model ? '- ' . $product->model : '' }}
                                    </p>
                                </div>

                                @if($product->price)
                                    <div style="text-align: right;">
                                        <p style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900);">
                                            ${{ number_format($product->price, 2) }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            @if($product->description)
                                <p class="text-muted" style="font-size: var(--text-base); margin-bottom: var(--spacing-md); line-height: var(--leading-relaxed);">
                                    {{ $product->description }}
                                </p>
                            @endif

                            @if($product->pivot->notes)
                                <div style="background: var(--color-neutral-50); padding: var(--spacing-md); border-radius: var(--border-radius-md); margin-bottom: var(--spacing-md); border-left: 3px solid var(--color-primary);">
                                    <p style="font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-neutral-900); margin-bottom: var(--spacing-xs);">
                                        Why This Product:
                                    </p>
                                    <p style="font-size: var(--text-sm); color: var(--color-neutral-700);">
                                        {{ $product->pivot->notes }}
                                    </p>
                                </div>
                            @endif

                            <!-- Affiliate Links -->
                            @if($product->affiliateLinks->isNotEmpty())
                                <div style="display: flex; gap: var(--spacing-sm); flex-wrap: wrap; padding-top: var(--spacing-md); border-top: 1px solid var(--border-color);">
                                    @foreach($product->affiliateLinks->where('is_active', true) as $link)
                                        <a href="{{ $link->affiliate_url }}" target="_blank" rel="nofollow noopener" class="btn btn-primary" style="font-size: var(--text-sm);">
                                            Buy at {{ $link->store->name }} 
                                            @if($link->price)
                                                - ${{ number_format($link->price, 2) }}
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    @media (min-width: 768px) {
        .card > div {
            grid-template-columns: 150px 1fr !important;
        }
    }
</style>
@endsection
