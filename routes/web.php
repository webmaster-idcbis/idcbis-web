<?php

use App\Http\Controllers\ResponsiveImageController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', SitemapController::class);
Route::get('/robots.txt', RobotsController::class);

Route::get('/img/{path}', [ResponsiveImageController::class, 'show'])
    ->where('path', '.*-\d+w\.webp');

// SPA - All routes handled by Vue Router
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');
