@extends('layouts.app')

@section('title', $savedBuild->name . ' | My Builds | FishingGearPicker')

@section('content')
<!-- Breadcrumb -->
<div style="background: var(--color-neutral-50); border-bottom: 1px solid var(--border-color); padding: var(--spacing-md) 0;">
    <div class="container-custom">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="breadcrumb-separator">/</span>
            <a href="{{ route('profile.builds') }}">My Builds</a>
            <span class="breadcrumb-separator">/</span>
            <span>{{ $savedBuild->name }}</span>
        </nav>
    </div>
</div>

<!-- Build Header -->
<div style="background: white; padding: var(--spacing-2xl) 0; border-bottom: 1px solid var(--border-color);">
    <div class="container-custom">
        <div style="display: flex; gap: var(--spacing-xs); margin-bottom: var(--spacing-lg); flex-wrap: wrap;">
            <span class="badge">
                {{ $savedBuild->originalBuild->technique->name }}
            </span>
            <span class="badge">
                {{ $savedBuild->originalBuild->species->name }}
            </span>
            <span class="badge">
                {{ ucfirst($savedBuild->originalBuild->budget_tier) }} Budget
            </span>
            @if($savedBuild->is_public)
                <span class="badge" style="background: var(--color-neutral-900); color: white;">
                    🌐 Public
                </span>
            @else
                <span class="badge">
                    🔒 Private
                </span>
            @endif
        </div>

        <h1 style="font-size: var(--text-4xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-md); max-width: 900px;">
            {{ $savedBuild->name }}
        </h1>

        @if($savedBuild->description)
            <p style="font-size: var(--text-lg); color: var(--color-neutral-700); margin-bottom: var(--spacing-xl); max-width: 800px; line-height: var(--leading-relaxed);">
                {{ $savedBuild->description }}
            </p>
        @endif

        <div style="display: flex; align-items: center; justify-content: space-between; padding-top: var(--spacing-lg); border-top: 1px solid var(--border-color); flex-wrap: wrap; gap: var(--spacing-md);">
            <div style="display: flex; flex-direction: column;">
                <span style="font-size: var(--text-sm); color: var(--color-neutral-600); margin-bottom: var(--spacing-xs);">Created By</span>
                <span style="font-size: var(--text-base); font-weight: var(--font-semibold); color: var(--color-neutral-900);">
                    {{ $savedBuild->user->name }}
                </span>
            </div>

            <div style="text-align: right;">
                <p style="font-size: var(--text-sm); color: var(--color-neutral-600); margin-bottom: var(--spacing-xs);">Total Price</p>
                <p style="font-size: var(--text-4xl); font-weight: var(--font-bold); color: var(--color-neutral-900);">${{ number_format($savedBuild->total_price, 2) }}</p>
            </div>
        </div>

        @if($savedBuild->user_id === auth()->id())
            <div style="display: flex; gap: var(--spacing-sm); margin-top: var(--spacing-lg);">
                <a href="{{ route('builds.show', $savedBuild->originalBuild->slug) }}" class="btn">
                    View Original Build
                </a>
                <form action="{{ route('profile.builds.destroy', $savedBuild->slug) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this build?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="background: #dc2626; color: white;">
                        Delete Build
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>

<!-- Products Section -->
<div class="section" style="background: var(--color-neutral-50);">
    <div class="container-custom">
        <h2 style="font-size: var(--text-3xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-2xl);">
            Your Selected Gear
        </h2>

        <div style="display: flex; flex-direction: column; gap: var(--spacing-xl);">
            @foreach($savedBuild->products as $product)
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
                                        {{ ucfirst($product->pivot->role) }}
                                    </span>
                                    @if($product->pivot->quantity > 1)
                                        <span class="badge" style="margin-left: var(--spacing-xs);">
                                            Qty: {{ $product->pivot->quantity }}
                                        </span>
                                    @endif
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
                                            ${{ number_format($product->price * $product->pivot->quantity, 2) }}
                                        </p>
                                        @if($product->pivot->quantity > 1)
                                            <p style="font-size: var(--text-xs); color: var(--color-neutral-600);">
                                                ${{ number_format($product->price, 2) }} each
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            @if($product->description)
                                <p class="text-muted" style="font-size: var(--text-base); margin-bottom: var(--spacing-md); line-height: var(--leading-relaxed);">
                                    {{ $product->description }}
                                </p>
                            @endif

                            @if($product->pivot->notes)
                                <div style="background: var(--color-neutral-50); padding: var(--spacing-md); border-radius: var(--border-radius-md); margin-bottom: var(--spacing-md); border-left: 3px solid var(--color-neutral-900);">
                                    <p style="font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-neutral-900); margin-bottom: var(--spacing-xs);">
                                        Your Notes:
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
                                        <a href="{{ $link->affiliate_url }}" target="_blank" rel="nofollow noopener" class="btn" style="font-size: var(--text-sm);">
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

