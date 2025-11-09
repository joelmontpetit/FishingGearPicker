<?php

namespace App\Http\Controllers;

use App\Models\Build;
use App\Models\Technique;
use App\Models\Species;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the home page
     */
    public function index()
    {
        $featuredBuilds = Build::with(['technique', 'species'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('views_count', 'desc')
            ->limit(6)
            ->get();

        $techniques = Technique::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        $species = Species::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        return view('home', compact('featuredBuilds', 'techniques', 'species'));
    }

    /**
     * Show techniques page
     */
    public function techniques()
    {
        $techniques = Technique::withCount('builds')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('techniques.index', compact('techniques'));
    }

    /**
     * Show technique detail page
     */
    public function techniqueShow($slug)
    {
        $technique = Technique::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $builds = Build::with(['species'])
            ->where('technique_id', $technique->id)
            ->where('is_active', true)
            ->orderBy('views_count', 'desc')
            ->paginate(12);

        return view('techniques.show', compact('technique', 'builds'));
    }

    /**
     * Show build detail page
     */
    public function buildShow($slug)
    {
        $build = Build::with(['technique', 'species', 'products.productType', 'products.affiliateLinks.store'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Increment view count
        $build->incrementViews();

        return view('builds.show', compact('build'));
    }

    /**
     * Show product detail page
     */
    public function productShow($slug)
    {
        $product = \App\Models\Product::with(['productType', 'affiliateLinks.store', 'builds'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('products.show', compact('product'));
    }

    /**
     * Show species page
     */
    public function species()
    {
        $species = Species::withCount('builds')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('species.index', compact('species'));
    }

    /**
     * Show species detail page
     */
    public function speciesShow($slug)
    {
        $species = Species::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $builds = Build::with(['technique'])
            ->where('species_id', $species->id)
            ->where('is_active', true)
            ->orderBy('views_count', 'desc')
            ->paginate(12);

        return view('species.show', compact('species', 'builds'));
    }
}

