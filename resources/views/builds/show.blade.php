@extends('layouts.app')

@section('title', $build->meta_tags['title'] ?? $build->name . ' | FishingGearPicker')
@section('meta_description', $build->meta_tags['description'] ?? $build->description)
@section('meta_keywords', $build->meta_tags['keywords'] ?? '')

@section('content')
<div x-data="buildPage()">
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

            <div style="display: flex; align-items: center; gap: var(--spacing-md); flex-wrap: wrap;">
                @if($build->total_price)
                    <div style="text-align: right;">
                        <p style="font-size: var(--text-sm); color: var(--color-neutral-600); margin-bottom: var(--spacing-xs);">Total Price</p>
                        <p style="font-size: var(--text-4xl); font-weight: var(--font-bold); color: var(--color-neutral-900);">${{ number_format($build->total_price, 2) }}</p>
                    </div>
                @endif

                @auth
                    <button 
                        @click="showSaveModal = true"
                        class="btn"
                        style="display: flex; align-items: center; gap: var(--spacing-xs);">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        Save This Build
                    </button>
                @else
                    <a href="{{ route('login') }}" class="btn" style="display: flex; align-items: center; gap: var(--spacing-xs);">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        Login to Save Build
                    </a>
                @endauth
            </div>
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
            @php
                // Group products by role
                $productsByRole = $build->productOptions->groupBy('role');
            @endphp

            @foreach($productsByRole as $role => $options)
                <div class="card" x-data="productCarousel()">
                    <!-- Role Header with Price Tier Selector -->
                    <div style="padding: var(--spacing-lg); border-bottom: 1px solid var(--border-color); background: var(--color-neutral-50);">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--spacing-md);">
                            <div>
                                <span class="badge" style="margin-bottom: var(--spacing-xs);">
                                    {{ ucfirst($role) }}
                                </span>
                                <h3 style="font-size: var(--text-xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-top: var(--spacing-xs);">
                                    Choose Your {{ ucfirst($role) }}
                                </h3>
                            </div>

                            <!-- Price Tier Tabs -->
                            <div style="display: flex; gap: var(--spacing-xs); background: white; padding: 4px; border-radius: var(--border-radius-md); border: 1px solid var(--border-color);">
                                @foreach($options->sortBy('sort_order')->groupBy('price_tier') as $tier => $tierOptions)
                                    <button 
                                        @click="currentIndex = {{ $loop->index }}"
                                        :class="currentIndex === {{ $loop->index }} ? 'active' : ''"
                                        class="tier-tab"
                                        style="padding: var(--spacing-xs) var(--spacing-md); border-radius: var(--border-radius-sm); font-size: var(--text-sm); font-weight: var(--font-semibold); border: none; cursor: pointer; transition: all var(--transition-fast);">
                                        @if($tier === 'budget')
                                            💰 Budget
                                        @elseif($tier === 'mid')
                                            💎 Mid-Range
                                        @elseif($tier === 'premium')
                                            ⭐ Premium
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Product Carousel -->
                    <div style="position: relative; overflow: hidden;">
                        @foreach($options->sortBy('sort_order')->groupBy('price_tier') as $tier => $tierOptions)
                            <div x-show="currentIndex === {{ $loop->index }}" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform translate-x-4"
                                 x-transition:enter-end="opacity-100 transform translate-x-0"
                                 style="padding: var(--spacing-xl);">
                                
                                @foreach($tierOptions as $option)
                                    @php $product = $option->product; @endphp
                                    
                                    <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-lg);" class="product-carousel-item">
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
                                                    @if($option->is_recommended)
                                                        <span class="badge" style="margin-bottom: var(--spacing-xs); background: var(--color-neutral-900); color: white;">
                                                            ⭐ Recommended
                                                        </span>
                                                    @endif
                                                    <h4 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900); margin-top: var(--spacing-xs);">
                                                        <a href="{{ route('products.show', $product->slug) }}" style="color: var(--color-neutral-900); text-decoration: none; transition: color var(--transition-fast);" onmouseover="this.style.color='var(--color-primary)'" onmouseout="this.style.color='var(--color-neutral-900)'">
                                                            {{ $product->name }}
                                                        </a>
                                                    </h4>
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

                                            @if($option->notes)
                                                <div style="background: var(--color-neutral-50); padding: var(--spacing-md); border-radius: var(--border-radius-md); margin-bottom: var(--spacing-md); border-left: 3px solid var(--color-neutral-900);">
                                                    <p style="font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-neutral-900); margin-bottom: var(--spacing-xs);">
                                                        Why This Product:
                                                    </p>
                                                    <p style="font-size: var(--text-sm); color: var(--color-neutral-700);">
                                                        {{ $option->notes }}
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
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Save Build Modal -->
@auth
<div x-show="showSaveModal" 
     x-cloak
     @click.self="showSaveModal = false"
     style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000; padding: var(--spacing-md);">
    <div @click.stop 
         style="background: white; border-radius: var(--border-radius-lg); max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: var(--shadow-xl);">
        
        <!-- Modal Header -->
        <div style="padding: var(--spacing-xl); border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--color-neutral-900);">
                Save Your Custom Build
            </h3>
            <button @click="showSaveModal = false" style="padding: var(--spacing-xs); background: none; border: none; cursor: pointer; color: var(--color-neutral-500); transition: color var(--transition-fast);" onmouseover="this.style.color='var(--color-neutral-900)'" onmouseout="this.style.color='var(--color-neutral-500)'">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <form @submit.prevent="saveBuild" style="padding: var(--spacing-xl);">
            <div style="display: flex; flex-direction: column; gap: var(--spacing-lg);">
                <!-- Build Name -->
                <div>
                    <label style="display: block; font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-neutral-900); margin-bottom: var(--spacing-xs);">
                        Build Name <span style="color: var(--color-neutral-500);">*</span>
                    </label>
                    <input 
                        type="text" 
                        x-model="saveForm.name"
                        required
                        placeholder="e.g., My Carolina Rig Setup"
                        style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--border-color); border-radius: var(--border-radius-md); font-size: var(--text-base);">
                </div>

                <!-- Description -->
                <div>
                    <label style="display: block; font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-neutral-900); margin-bottom: var(--spacing-xs);">
                        Notes (Optional)
                    </label>
                    <textarea 
                        x-model="saveForm.description"
                        rows="3"
                        placeholder="Add any notes about your build choices..."
                        style="width: 100%; padding: var(--spacing-md); border: 1px solid var(--border-color); border-radius: var(--border-radius-md); font-size: var(--text-base); resize: vertical;"></textarea>
                </div>

                <!-- Public/Private -->
                <div style="display: flex; align-items: center; gap: var(--spacing-sm);">
                    <input 
                        type="checkbox" 
                        x-model="saveForm.is_public"
                        id="is_public"
                        style="width: 20px; height: 20px; cursor: pointer;">
                    <label for="is_public" style="font-size: var(--text-sm); color: var(--color-neutral-700); cursor: pointer;">
                        Make this build public (others can view it)
                    </label>
                </div>

                <!-- Selected Products Summary -->
                <div style="background: var(--color-neutral-50); padding: var(--spacing-md); border-radius: var(--border-radius-md); border: 1px solid var(--border-color);">
                    <h4 style="font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-neutral-900); margin-bottom: var(--spacing-sm);">
                        Selected Products:
                    </h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: var(--spacing-xs);">
                        <template x-for="(selection, role) in selectedProducts" :key="role">
                            <li style="font-size: var(--text-sm); color: var(--color-neutral-700);">
                                <span style="font-weight: var(--font-semibold);" x-text="role"></span>: 
                                <span x-text="selection.name"></span>
                            </li>
                        </template>
                    </ul>
                    <div style="margin-top: var(--spacing-md); padding-top: var(--spacing-md); border-top: 1px solid var(--border-color);">
                        <span style="font-size: var(--text-sm); font-weight: var(--font-semibold); color: var(--color-neutral-900);">Total Price: </span>
                        <span style="font-size: var(--text-lg); font-weight: var(--font-bold); color: var(--color-neutral-900);" x-text="'$' + totalPrice.toFixed(2)"></span>
                    </div>
                </div>

                <!-- Error Message -->
                <div x-show="saveError" style="background: #fee2e2; border: 1px solid #dc2626; border-radius: var(--border-radius-md); padding: var(--spacing-md);">
                    <p style="font-size: var(--text-sm); color: #dc2626;" x-text="saveError"></p>
                </div>

                <!-- Success Message -->
                <div x-show="saveSuccess" style="background: #d1fae5; border: 1px solid #10b981; border-radius: var(--border-radius-md); padding: var(--spacing-md);">
                    <p style="font-size: var(--text-sm); color: #10b981;">Build saved successfully!</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div style="display: flex; justify-content: flex-end; gap: var(--spacing-sm); margin-top: var(--spacing-xl); padding-top: var(--spacing-lg); border-top: 1px solid var(--border-color);">
                <button 
                    type="button"
                    @click="showSaveModal = false"
                    class="btn"
                    style="background: var(--color-neutral-200); color: var(--color-neutral-700);">
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="btn"
                    :disabled="saving"
                    style="background: var(--color-neutral-900); color: white;">
                    <span x-show="!saving">Save Build</span>
                    <span x-show="saving">Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endauth
</div>

<style>
    @media (min-width: 768px) {
        .product-carousel-item {
            grid-template-columns: 150px 1fr !important;
        }
    }

    .tier-tab {
        background: white;
        color: var(--color-neutral-600);
    }

    .tier-tab:hover {
        background: var(--color-neutral-100);
        color: var(--color-neutral-900);
    }

    .tier-tab.active {
        background: var(--color-neutral-900);
        color: white;
    }

    [x-cloak] {
        display: none !important;
    }
</style>

<script>
    function buildPage() {
        return {
            // Carousel state per role
            carousels: {},
            
            // Save modal state
            showSaveModal: false,
            saving: false,
            saveError: '',
            saveSuccess: false,
            
            // Save form data
            saveForm: {
                name: '{{ $build->name }} - Custom',
                description: '',
                is_public: false,
                original_build_id: {{ $build->id }}
            },

            // Selected products (tracking user's choices)
            selectedProducts: {},
            totalPrice: 0,

            init() {
                // Initialize selected products from default/recommended options
                this.initializeSelections();
            },

            initializeSelections() {
                const productsByRole = @json($build->productOptions->groupBy('role'));
                
                for (const [role, options] of Object.entries(productsByRole)) {
                    // Find recommended or first option
                    const recommended = options.find(opt => opt.is_recommended);
                    const defaultOption = recommended || options[0];
                    
                    if (defaultOption) {
                        this.selectedProducts[role] = {
                            product_id: defaultOption.product_id,
                            role: role,
                            name: defaultOption.product.name,
                            price: defaultOption.product.price || 0,
                            quantity: 1
                        };
                    }
                }
                
                this.calculateTotalPrice();
            },

            selectProduct(role, product, tierIndex) {
                this.selectedProducts[role] = {
                    product_id: product.id,
                    role: role,
                    name: product.name,
                    price: product.price || 0,
                    quantity: 1
                };
                this.calculateTotalPrice();
            },

            calculateTotalPrice() {
                this.totalPrice = Object.values(this.selectedProducts).reduce((sum, product) => {
                    return sum + (product.price * product.quantity);
                }, 0);
            },

            async saveBuild() {
                this.saving = true;
                this.saveError = '';
                this.saveSuccess = false;

                // Prepare products data
                const products = Object.values(this.selectedProducts).map(product => ({
                    product_id: product.product_id,
                    role: product.role,
                    quantity: product.quantity,
                    notes: null
                }));

                try {
                    const response = await fetch('{{ route('profile.builds.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            ...this.saveForm,
                            products: products
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        this.saveSuccess = true;
                        setTimeout(() => {
                            window.location.href = data.redirect_url;
                        }, 1000);
                    } else {
                        this.saveError = data.message || 'Failed to save build. Please try again.';
                    }
                } catch (error) {
                    this.saveError = 'An error occurred. Please try again.';
                    console.error('Save build error:', error);
                } finally {
                    this.saving = false;
                }
            }
        }
    }

    function productCarousel() {
        return {
            currentIndex: 0
        }
    }
</script>
@endsection
