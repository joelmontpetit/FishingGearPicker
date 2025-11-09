<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $seoMeta->meta_title ?? 'FishingGearPicker - Complete Fishing Gear Recommendations' }}</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $seoMeta->meta_description ?? 'Find the perfect fishing gear setup for your technique and target species. Complete builds with affiliate links from top retailers.' }}">
    @if(isset($seoMeta->meta_keywords) && $seoMeta->meta_keywords)
    <meta name="keywords" content="{{ $seoMeta->meta_keywords }}">
    @endif
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $seoMeta->og_title ?? $seoMeta->meta_title ?? 'FishingGearPicker' }}">
    <meta property="og:description" content="{{ $seoMeta->og_description ?? $seoMeta->meta_description ?? 'Complete fishing gear recommendations' }}">
    @if(isset($seoMeta->og_image) && $seoMeta->og_image)
    <meta property="og:image" content="{{ $seoMeta->og_image }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="{{ $seoMeta->twitter_card ?? 'summary_large_image' }}">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $seoMeta->og_title ?? $seoMeta->meta_title ?? 'FishingGearPicker' }}">
    <meta property="twitter:description" content="{{ $seoMeta->og_description ?? $seoMeta->meta_description ?? 'Complete fishing gear recommendations' }}">
    @if(isset($seoMeta->og_image) && $seoMeta->og_image)
    <meta property="twitter:image" content="{{ $seoMeta->og_image }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Navigation -->
    <nav style="background: white; border-bottom: 1px solid var(--border-color); position: sticky; top: 0; z-index: 50;">
        <div class="container-custom" style="display: flex; justify-content: space-between; align-items: center; height: 70px;">
            <!-- Logo -->
            <a href="{{ route('home') }}" style="font-size: var(--text-xl); font-weight: var(--font-bold); color: var(--color-neutral-900); text-decoration: none; letter-spacing: -0.025em;">
                FishingGearPicker
            </a>

            <!-- Navigation Links -->
            <div style="display: none; gap: var(--spacing-2xl);" class="nav-links">
                <a href="{{ route('home') }}" style="color: var(--color-neutral-800); text-decoration: none; font-size: var(--text-base); font-weight: var(--font-medium); transition: color var(--transition-fast);" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color='var(--color-neutral-800)'">
                    Home
                </a>
                <a href="{{ route('techniques.index') }}" style="color: var(--color-neutral-800); text-decoration: none; font-size: var(--text-base); font-weight: var(--font-medium); transition: color var(--transition-fast);" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color='var(--color-neutral-800)'">
                    Techniques
                </a>
                <a href="{{ route('species.index') }}" style="color: var(--color-neutral-800); text-decoration: none; font-size: var(--text-base); font-weight: var(--font-medium); transition: color var(--transition-fast);" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color='var(--color-neutral-800)'">
                    Species
                </a>
                <a href="/admin" style="color: var(--color-neutral-600); text-decoration: none; font-size: var(--text-sm); font-weight: var(--font-medium); transition: color var(--transition-fast);" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color='var(--color-neutral-600)'">
                    Admin
                </a>
            </div>
        </div>
    </nav>
    
    <style>
        @media (min-width: 768px) {
            .nav-links {
                display: flex !important;
            }
        }
    </style>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background: var(--color-neutral-900); color: white; margin-top: var(--spacing-3xl); border-top: 1px solid var(--color-neutral-800);">
        <div class="container-custom" style="padding-top: var(--spacing-3xl); padding-bottom: var(--spacing-2xl);">
            <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-xl);">
                <!-- About -->
                <div style="grid-column: span 2;">
                    <h3 style="font-size: var(--text-xl); font-weight: var(--font-bold); margin-bottom: var(--spacing-md); color: white;">FishingGearPicker</h3>
                    <p style="color: var(--color-neutral-400); margin-bottom: var(--spacing-md); max-width: 500px; line-height: var(--leading-relaxed);">
                        Your ultimate resource for fishing gear recommendations. We curate complete setups based on techniques and target species.
                    </p>
                    <p style="font-size: var(--text-sm); color: var(--color-neutral-500);">
                        © {{ date('Y') }} FishingGearPicker. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    
    <style>
        @media (min-width: 768px) {
            footer > div > div {
                grid-template-columns: repeat(3, 1fr) !important;
            }
        }
    </style>
</body>
</html>

