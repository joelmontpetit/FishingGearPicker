@extends('layouts.app')

@section('title', $product->name . ' - FishingGearPicker')
@section('meta_description', $product->description)

@section('content')
<!-- Breadcrumb -->
<div style="background: var(--color-neutral-50); border-bottom: 1px solid var(--border-color); padding: var(--spacing-md) 0;">
    <div class="container-custom">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="breadcrumb-separator">/</span>
            <span>{{ $product->name }}</span>
        </nav>
    </div>
</div>

<!-- Product Details -->
<div class="section" style="background: white; padding-top: var(--spacing-2xl);">
    <div class="container-custom">
        <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-3xl); max-width: 1000px;">
            <!-- Product Image -->
            <div>
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; max-width: 500px; height: auto; border-radius: var(--border-radius-lg); box-shadow: var(--shadow-lg);">
                @else
                    <div style="width: 100%; max-width: 500px; height: 400px; background: linear-gradient(135deg, var(--color-neutral-200) 0%, var(--color-neutral-300) 100%); border-radius: var(--border-radius-lg); display: flex; align-items: center; justify-content: center; font-size: 6rem;">
                        🎣
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <span class="badge" style="margin-bottom: var(--spacing-md);">
                    {{ $product->productType->name }}
                </span>

                <h1 style="font-size: var(--text-4xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-sm);">
                    {{ $product->name }}
                </h1>

                <p style="font-size: var(--text-lg); color: var(--color-neutral-600); margin-bottom: var(--spacing-xl);">
                    {{ $product->brand }} {{ $product->model ? '- ' . $product->model : '' }}
                </p>

                @if($product->price)
                    <p style="font-size: var(--text-4xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-bottom: var(--spacing-xl);">
                        ${{ number_format($product->price, 2) }}
                    </p>
                @endif

                @if($product->description)
                    <p class="text-muted" style="font-size: var(--text-base); margin-bottom: var(--spacing-xl); line-height: var(--leading-relaxed);">
                        {{ $product->description }}
                    </p>
                @endif

                <!-- Affiliate Links -->
                @if($product->affiliateLinks->isNotEmpty())
                    <div style="margin-bottom: var(--spacing-2xl);">
                        <h3 style="font-size: var(--text-lg); font-weight: var(--font-semibold); color: var(--color-neutral-900); margin-bottom: var(--spacing-md);">
                            Where to Buy
                        </h3>
                        <div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
                            @foreach($product->affiliateLinks->where('is_active', true) as $link)
                                <a href="{{ $link->affiliate_url }}" target="_blank" rel="nofollow noopener" class="btn btn-primary" style="width: 100%; justify-content: space-between;">
                                    <span>{{ $link->store->name }}</span>
                                    @if($link->price)
                                        <span>${{ number_format($link->price, 2) }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Specifications -->
                @if($product->specifications)
                    <div style="border-top: 1px solid var(--border-color); padding-top: var(--spacing-xl);">
                        <h3 style="font-size: var(--text-lg); font-weight: var(--font-semibold); color: var(--color-neutral-900); margin-bottom: var(--spacing-md);">
                            Specifications
                        </h3>
                        <dl style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-sm);">
                            @foreach($product->specifications as $key => $value)
                                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: var(--spacing-md); padding: var(--spacing-sm) 0; border-bottom: 1px solid var(--border-color);">
                                    <dt style="font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-neutral-700);">
                                        {{ ucwords(str_replace('_', ' ', $key)) }}
                                    </dt>
                                    <dd style="font-size: var(--text-sm); color: var(--color-neutral-800);">
                                        {{ $value }}
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @media (min-width: 1024px) {
        .container-custom > div {
            grid-template-columns: 500px 1fr !important;
        }
    }
</style>
@endsection
