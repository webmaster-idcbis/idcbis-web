<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PageTemplateController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Pages
    Route::apiResource('pages', PageController::class);
    Route::patch('/pages/{page}/publish', [PageController::class, 'publish']);
    Route::get('/page-templates', [PageTemplateController::class, 'index']);
    Route::post('/page-templates', [PageTemplateController::class, 'store']);
    Route::get('/page-templates/{pageTemplate}', [PageTemplateController::class, 'show']);
    Route::delete('/page-templates/{pageTemplate}', [PageTemplateController::class, 'destroy']);
    
    // Users
    Route::apiResource('users', UserController::class);
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/user/password', [UserController::class, 'changePassword']);
    
    // Roles
    Route::apiResource('roles', RoleController::class);
    Route::get('/permissions-by-role', [RoleController::class, 'permissions']);
    
    // Permissions
    Route::apiResource('permissions', PermissionController::class);
    Route::get('/permissions-grouped', [PermissionController::class, 'grouped']);
    Route::get('/permission-modules', [PermissionController::class, 'modules']);
    
    // Menus
    Route::apiResource('menus', MenuController::class);
    Route::get('/menus-available-pages', [MenuController::class, 'getAvailablePages']);
});

// Public pages
Route::get('/pages/slug/{slug}', [PageController::class, 'showBySlug']);
Route::get('/search', [SearchController::class, 'index']);

// Public menus
Route::get('/menus/public', [MenuController::class, 'getPublicMenus']);
