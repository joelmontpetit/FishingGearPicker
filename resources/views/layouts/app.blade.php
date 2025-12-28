<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <title>{{ $seoMeta->meta_title ?? config('app.name', 'FishingGearSetups.com') }}</title>
    <meta name="description" content="{{ $seoMeta->meta_description ?? 'Découvrez les meilleures recommandations d\'équipement de pêche' }}">
    @if(isset($seoMeta->meta_keywords))
        <meta name="keywords" content="{{ $seoMeta->meta_keywords }}">
    @endif
    
    <!-- Open Graph -->
    <meta property="og:title" content="{{ $seoMeta->og_title ?? $seoMeta->meta_title ?? config('app.name') }}">
    <meta property="og:description" content="{{ $seoMeta->og_description ?? $seoMeta->meta_description ?? 'Découvrez les meilleures recommandations d\'équipement de pêche' }}">
    @if(isset($seoMeta->og_image))
        <meta property="og:image" content="{{ $seoMeta->og_image }}">
    @endif
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="{{ $seoMeta->twitter_card ?? 'summary_large_image' }}">
    <meta name="twitter:title" content="{{ $seoMeta->og_title ?? $seoMeta->meta_title ?? config('app.name') }}">
    <meta name="twitter:description" content="{{ $seoMeta->og_description ?? $seoMeta->meta_description ?? 'Découvrez les meilleures recommandations d\'équipement de pêche' }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="font-family: var(--font-sans); background: var(--color-neutral-50); color: var(--color-text-primary); margin: 0; padding: 0; line-height: var(--line-height-normal);">
    <!-- Navigation -->
    <nav style="background: white; border-bottom: 1px solid var(--border-color); position: sticky; top: 0; z-index: 50;" x-data="{ mobileMenuOpen: false }">
        <div class="container-custom" style="display: flex; justify-content: space-between; align-items: center; height: 64px;">
            <!-- Logo -->
            <a href="{{ route('home') }}" style="font-size: 20px; font-weight: 700; color: var(--color-text-primary); text-decoration: none; letter-spacing: -0.01em;">
                FishingGearSetups.com
            </a>
            
            <!-- Desktop Navigation Links -->
            <div class="hide-mobile" style="display: flex; gap: var(--spacing-lg); align-items: center;">
                <a href="{{ route('species.index') }}" class="link-subtle" style="font-size: 15px; font-weight: 500;">
                    Species
                </a>
                <a href="{{ route('techniques.index') }}" class="link-subtle" style="font-size: 15px; font-weight: 500;">
                    Techniques
                </a>
                
                @auth
                    <!-- User Dropdown -->
                    <div style="position: relative;" x-data="{ open: false }">
                        <button @click="open = !open" style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; border: 1px solid var(--border-color); border-radius: var(--border-radius); background: white; cursor: pointer; font-size: 14px;">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                            @endif
                            <span>{{ Auth::user()->name }}</span>
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor">
                                <path d="M6 8L2 4h8L6 8z"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-cloak style="position: absolute; right: 0; top: 100%; margin-top: 8px; background: white; border: 1px solid var(--border-color); border-radius: var(--border-radius); box-shadow: var(--shadow-md); min-width: 200px; padding: 8px 0;">
                            <a href="{{ route('dashboard') }}" style="display: block; padding: 10px 16px; color: var(--color-text-primary); text-decoration: none; font-size: 14px; transition: background 0.2s;" onmouseover="this.style.background='var(--color-neutral-100)'" onmouseout="this.style.background='transparent'">
                                Dashboard
                            </a>
                            <a href="{{ route('profile.builds') }}" style="display: block; padding: 10px 16px; color: var(--color-text-primary); text-decoration: none; font-size: 14px; transition: background 0.2s;" onmouseover="this.style.background='var(--color-neutral-100)'" onmouseout="this.style.background='transparent'">
                                My Builds
                            </a>
                            <a href="{{ route('profile.edit') }}" style="display: block; padding: 10px 16px; color: var(--color-text-primary); text-decoration: none; font-size: 14px; transition: background 0.2s;" onmouseover="this.style.background='var(--color-neutral-100)'" onmouseout="this.style.background='transparent'">
                                Profile
                            </a>
                            <div style="height: 1px; background: var(--border-color); margin: 8px 0;"></div>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" style="width: 100%; text-align: left; padding: 10px 16px; background: none; border: none; color: var(--color-text-primary); font-size: 14px; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='var(--color-neutral-100)'" onmouseout="this.style.background='transparent'">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="link-subtle" style="font-size: 15px; font-weight: 500;">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn" style="font-size: 14px;">
                        Sign Up
                    </a>
                @endauth
            </div>

            <!-- Mobile Burger Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="mobile-burger-btn">
                <span :style="mobileMenuOpen ? 'transform: rotate(45deg) translateY(6px);' : ''"></span>
                <span :style="mobileMenuOpen ? 'opacity: 0;' : ''"></span>
                <span :style="mobileMenuOpen ? 'transform: rotate(-45deg) translateY(-6px);' : ''"></span>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             style="background: white; border-top: 1px solid var(--border-color); padding: var(--spacing-md) 0;">
            <div class="container-custom" style="display: flex; flex-direction: column; gap: var(--spacing-xs);">
                <a href="{{ route('species.index') }}" style="padding: 12px 16px; color: var(--color-text-primary); text-decoration: none; font-size: 15px; font-weight: 500; border-radius: var(--border-radius); transition: background 0.2s;" onmouseover="this.style.background='var(--color-neutral-50)'" onmouseout="this.style.background='transparent'">
                    Species
                </a>
                <a href="{{ route('techniques.index') }}" style="padding: 12px 16px; color: var(--color-text-primary); text-decoration: none; font-size: 15px; font-weight: 500; border-radius: var(--border-radius); transition: background 0.2s;" onmouseover="this.style.background='var(--color-neutral-50)'" onmouseout="this.style.background='transparent'">
                    Techniques
                </a>
                
                <div style="height: 1px; background: var(--border-color); margin: var(--spacing-sm) 0;"></div>
                
                @auth
                    <a href="{{ route('dashboard') }}" style="padding: 12px 16px; color: var(--color-text-primary); text-decoration: none; font-size: 15px; font-weight: 500; border-radius: var(--border-radius); transition: background 0.2s;" onmouseover="this.style.background='var(--color-neutral-50)'" onmouseout="this.style.background='transparent'">
                        Dashboard
                    </a>
                    <a href="{{ route('profile.builds') }}" style="padding: 12px 16px; color: var(--color-text-primary); text-decoration: none; font-size: 15px; font-weight: 500; border-radius: var(--border-radius); transition: background 0.2s;" onmouseover="this.style.background='var(--color-neutral-50)'" onmouseout="this.style.background='transparent'">
                        My Builds
                    </a>
                    <a href="{{ route('profile.edit') }}" style="padding: 12px 16px; color: var(--color-text-primary); text-decoration: none; font-size: 15px; font-weight: 500; border-radius: var(--border-radius); transition: background 0.2s;" onmouseover="this.style.background='var(--color-neutral-50)'" onmouseout="this.style.background='transparent'">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" style="width: 100%; text-align: left; padding: 12px 16px; background: none; border: none; color: var(--color-text-primary); font-size: 15px; font-weight: 500; cursor: pointer; border-radius: var(--border-radius); transition: background 0.2s;" onmouseover="this.style.background='var(--color-neutral-50)'" onmouseout="this.style.background='transparent'">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" style="padding: 12px 16px; color: var(--color-text-primary); text-decoration: none; font-size: 15px; font-weight: 500; border-radius: var(--border-radius); transition: background 0.2s;" onmouseover="this.style.background='var(--color-neutral-50)'" onmouseout="this.style.background='transparent'">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn" style="margin: 8px 16px; text-align: center;">
                        Sign Up
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer style="background: white; border-top: 1px solid var(--border-color); margin-top: var(--spacing-2xl); padding: var(--spacing-2xl) 0;">
        <div class="container-custom">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--spacing-xl);">
                <!-- About -->
                <div>
                    <h3 style="font-size: 18px; font-weight: 600; margin: 0 0 var(--spacing-md) 0;">FishingGearSetups.com</h3>
                    <p style="font-size: 14px; color: var(--color-text-tertiary); line-height: 1.6; margin: 0;">
                        Discover the best fishing gear recommendations for all techniques and species.
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; margin: 0 0 var(--spacing-md) 0; text-transform: uppercase; letter-spacing: 0.05em;">Navigation</h4>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 8px;">
                            <a href="{{ route('species.index') }}" class="link-subtle" style="font-size: 14px;">Species</a>
                        </li>
                        <li style="margin-bottom: 8px;">
                            <a href="{{ route('techniques.index') }}" class="link-subtle" style="font-size: 14px;">Techniques</a>
                        </li>
                    </ul>
                </div>
                
                <!-- Legal -->
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; margin: 0 0 var(--spacing-md) 0; text-transform: uppercase; letter-spacing: 0.05em;">Information</h4>
                    <p style="font-size: 13px; color: var(--color-text-tertiary); line-height: 1.6; margin: 0;">
                        Affiliate links help us keep this service free.
                    </p>
                </div>
            </div>
            
            <!-- Copyright -->
            <div style="margin-top: var(--spacing-xl); padding-top: var(--spacing-lg); border-top: 1px solid var(--border-color); text-align: center;">
                <p style="font-size: 13px; color: var(--color-text-tertiary); margin: 0;">
                    © {{ date('Y') }} FishingGearSetups.com. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js for dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
