<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/techniques', [HomeController::class, 'techniques'])->name('techniques.index');
Route::get('/techniques/{slug}', [HomeController::class, 'techniqueShow'])->name('techniques.show');
Route::get('/species', [HomeController::class, 'species'])->name('species.index');
Route::get('/species/{slug}', [HomeController::class, 'speciesShow'])->name('species.show');
Route::get('/builds/{slug}', [HomeController::class, 'buildShow'])->name('builds.show');
Route::get('/products/{slug}', [HomeController::class, 'productShow'])->name('products.show');
