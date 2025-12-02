@extends('layouts.app')

@section('title', $savedBuild->name . ' | My Builds | FishingGearPicker')
@section('meta_description', $savedBuild->description ?? 'Custom fishing gear build for ' . $savedBuild->originalBuild->technique->name . ' targeting ' . $savedBuild->originalBuild->species->name)

<!-- Open Graph Tags -->
@if($savedBuild->is_public)
    <meta property="og:title" content="{{ $savedBuild->name }}">
    <meta property="og:description" content="{{ $savedBuild->description ?? 'Custom fishing gear build' }}">
    <meta property="og:url" content="{{ route('profile.builds.show', $savedBuild->slug) }}">
    <meta property="og:type" content="article">
    
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $savedBuild->name }}">
    <meta name="twitter:description" content="{{ $savedBuild->description ?? 'Custom fishing gear build' }}">
@endif

@section('content')
<div x-data="{ showShareModal: false, copySuccess: false }"
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

        <div style="display: flex; gap: var(--spacing-sm); margin-top: var(--spacing-lg); flex-wrap: wrap;">
            @if($savedBuild->is_public)
                <button @click="showShareModal = true" class="btn" style="display: flex; align-items: center; gap: var(--spacing-xs);">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                    Share Build
                </button>
            @endif

            @if($savedBuild->user_id === auth()->id())
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
            @endif
        </div>
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

<!-- Share Modal -->
@if($savedBuild->is_public)
<div x-show="showShareModal" 
     x-cloak
     @click.self="showShareModal = false"
     style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000; padding: var(--spacing-md);">
    <div @click.stop 
         style="background: white; border-radius: var(--border-radius-lg); max-width: 500px; width: 100%; box-shadow: var(--shadow-xl);">
        
        <!-- Modal Header -->
        <div style="padding: var(--spacing-xl); border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900);">
                Share This Build
            </h3>
            <button @click="showShareModal = false" style="padding: var(--spacing-xs); background: none; border: none; cursor: pointer; color: var(--color-neutral-500); transition: color var(--transition-fast);" onmouseover="this.style.color='var(--color-neutral-900)'" onmouseout="this.style.color='var(--color-neutral-500)'">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div style="padding: var(--spacing-xl);">
            <p style="font-size: var(--text-sm); color: var(--color-neutral-600); margin-bottom: var(--spacing-md);">
                Share this build with others using the link below:
            </p>
            
            <div style="display: flex; gap: var(--spacing-sm); align-items: center;">
                <input 
                    type="text" 
                    readonly 
                    value="{{ route('profile.builds.show', $savedBuild->slug) }}"
                    id="shareLink"
                    style="flex: 1; padding: var(--spacing-md); border: 1px solid var(--border-color); border-radius: var(--border-radius-md); font-size: var(--text-sm); background: var(--color-neutral-50);">
                <button 
                    @click="
                        navigator.clipboard.writeText('{{ route('profile.builds.show', $savedBuild->slug) }}');
                        copySuccess = true;
                        setTimeout(() => copySuccess = false, 2000);
                    "
                    class="btn"
                    style="white-space: nowrap;">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </button>
            </div>

            <div x-show="copySuccess" x-transition style="margin-top: var(--spacing-md); background: #d1fae5; border: 1px solid #10b981; border-radius: var(--border-radius-md); padding: var(--spacing-sm);">
                <p style="font-size: var(--text-sm); color: #10b981); font-weight: var(--font-semibold); display: flex; align-items: center; gap: var(--spacing-xs);">
                    <svg style="width: 16px; height: 16px;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Link copied to clipboard!
                </p>
            </div>
        </div>
    </div>
</div>
@endif
</div>

<style>
    @media (min-width: 768px) {
        .card > div {
            grid-template-columns: 150px 1fr !important;
        }
    }

    [x-cloak] {
        display: none !important;
    }
</style>
@endsection

