<?php

use App\Http\Controllers\ResponsiveImageController;
use Illuminate\Support\Facades\Route;

Route::get('/img/{path}', [ResponsiveImageController::class, 'show'])
    ->where('path', '.*-\d+w\.webp');

// SPA - All routes handled by Vue Router
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');
