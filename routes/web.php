<?php

use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Models\Species;
use App\Models\Technique;
use App\Models\Build;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Species Routes
Route::get('/species', function () {
    $species = Species::orderBy('name')->get();
    return view('species.index', compact('species'));
})->name('species.index');

Route::get('/species/{species:slug}', function (Species $species) {
    $builds = Build::where('species_id', $species->id)
        ->with(['technique', 'species', 'products'])
        ->where('is_active', true)
        ->get();
    
    return view('species.show', compact('species', 'builds'));
})->name('species.show');

// Techniques Routes
Route::get('/techniques', function () {
    $techniques = Technique::orderBy('name')->get();
    return view('techniques.index', compact('techniques'));
})->name('techniques.index');

Route::get('/techniques/{technique:slug}', function (Technique $technique) {
    $builds = Build::where('technique_id', $technique->id)
        ->with(['technique', 'species', 'products'])
        ->where('is_active', true)
        ->get();
    
    return view('techniques.show', compact('technique', 'builds'));
})->name('techniques.show');

// Builds Routes
Route::get('/builds/{build:slug}', function (Build $build) {
    return view('builds.show', compact('build'));
})->name('builds.show');

// Products Routes
Route::get('/products/{product:slug}', function (Product $product) {
    return view('products.show', compact('product'));
})->name('products.show');

// Dashboard (protected)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes (protected)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Social Authentication Routes
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirectToProvider'])
    ->name('social.redirect')
    ->where('provider', 'google|facebook');

Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])
    ->name('social.callback')
    ->where('provider', 'google|facebook');

require __DIR__.'/auth.php';
