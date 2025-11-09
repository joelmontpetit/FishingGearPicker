<?php

namespace App\Providers;

use App\View\Composers\SeoComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Injecter les SEO metas dans toutes les vues frontend
        View::composer([
            'home',
            'techniques.index',
            'techniques.show',
            'species.index',
            'species.show',
            'builds.show',
            'products.show',
        ], SeoComposer::class);
    }
}
