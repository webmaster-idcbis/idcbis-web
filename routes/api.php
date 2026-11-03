<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PageTemplateController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\TranslateController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

// Public menus must be registered before menus/{menu}.
Route::get('/menus/public', [MenuController::class, 'getPublicMenus']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/user/password', [UserController::class, 'changePassword']);

    Route::middleware('permission:pages.view')->group(function () {
        Route::get('/pages', [PageController::class, 'index']);
        Route::get('/pages/{id}', [PageController::class, 'show'])->whereNumber('id');
        Route::get('/page-templates', [PageTemplateController::class, 'index']);
        Route::get('/page-templates/{pageTemplate}', [PageTemplateController::class, 'show']);
    });

    Route::middleware('permission:pages.create')->group(function () {
        Route::post('/pages', [PageController::class, 'store']);
    });

    Route::middleware('permission:pages.edit')->group(function () {
        Route::put('/pages/{id}', [PageController::class, 'update'])->whereNumber('id');
        Route::patch('/pages/{id}', [PageController::class, 'update'])->whereNumber('id');
        Route::post('/pages/{id}/save', [PageController::class, 'update'])->whereNumber('id');
        Route::post('/page-templates', [PageTemplateController::class, 'store']);
        Route::delete('/page-templates/{pageTemplate}', [PageTemplateController::class, 'destroy']);
    });

    Route::delete('/pages/{id}', [PageController::class, 'destroy'])
        ->whereNumber('id')
        ->middleware('permission:pages.delete');

    Route::patch('/pages/{page}/publish', [PageController::class, 'publish'])
        ->middleware('permission:pages.publish');

    Route::middleware('permission:posts.view')->group(function () {
        Route::get('/admin/posts', [PostController::class, 'adminIndex']);
        Route::get('/posts/{post}', [PostController::class, 'show'])->whereNumber('post');
    });

    Route::post('/posts', [PostController::class, 'store'])->middleware('permission:posts.create');

    Route::middleware('permission:posts.edit')->group(function () {
        Route::put('/posts/{post}', [PostController::class, 'update'])->whereNumber('post');
        Route::patch('/posts/{post}', [PostController::class, 'update'])->whereNumber('post');
        Route::post('/posts/{post}/save', [PostController::class, 'update'])->whereNumber('post');
    });

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->whereNumber('post')
        ->middleware('permission:posts.delete');

    Route::patch('/posts/{post}/publish', [PostController::class, 'publish'])
        ->whereNumber('post')
        ->middleware('permission:posts.publish');

    Route::middleware('permission:users.view')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{user}', [UserController::class, 'show']);
    });

    Route::post('/users', [UserController::class, 'store'])->middleware('permission:users.create');

    Route::middleware('permission:users.edit')->group(function () {
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::patch('/users/{user}', [UserController::class, 'update']);
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus']);
    });

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->middleware('permission:users.delete');

    Route::middleware('permission:roles.view')->group(function () {
        Route::get('/roles', [RoleController::class, 'index']);
        Route::get('/roles/{role}', [RoleController::class, 'show']);
        Route::get('/permissions-by-role', [RoleController::class, 'permissions']);
    });

    Route::post('/roles', [RoleController::class, 'store'])->middleware('permission:roles.create');

    Route::middleware('permission:roles.edit')->group(function () {
        Route::put('/roles/{role}', [RoleController::class, 'update']);
        Route::patch('/roles/{role}', [RoleController::class, 'update']);
    });

    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])
        ->middleware('permission:roles.delete');

    Route::middleware('permission:permissions.view')->group(function () {
        Route::get('/permissions', [PermissionController::class, 'index']);
        Route::get('/permissions/{permission}', [PermissionController::class, 'show']);
        Route::get('/permissions-grouped', [PermissionController::class, 'grouped']);
        Route::get('/permission-modules', [PermissionController::class, 'modules']);
    });

    Route::post('/permissions', [PermissionController::class, 'store'])
        ->middleware('permission:permissions.create');

    Route::middleware('permission:permissions.edit')->group(function () {
        Route::put('/permissions/{permission}', [PermissionController::class, 'update']);
        Route::patch('/permissions/{permission}', [PermissionController::class, 'update']);
    });

    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])
        ->middleware('permission:permissions.delete');

    Route::middleware('permission:menus.view')->group(function () {
        Route::get('/menus', [MenuController::class, 'index']);
        Route::get('/menus/{menu}', [MenuController::class, 'show'])->whereNumber('menu');
        Route::get('/menus-available-pages', [MenuController::class, 'getAvailablePages']);
    });

    Route::post('/menus', [MenuController::class, 'store'])
        ->middleware('permission:menus.create|menus.edit');

    Route::middleware('permission:menus.edit')->group(function () {
        Route::put('/menus/{menu}', [MenuController::class, 'update'])->whereNumber('menu');
        Route::patch('/menus/{menu}', [MenuController::class, 'update'])->whereNumber('menu');
    });

    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])
        ->whereNumber('menu')
        ->middleware('permission:menus.delete');
});

Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:10,1');

Route::post('/translate', TranslateController::class)->middleware('throttle:30,1');

Route::get('/pages/slug/{slug}', [PageController::class, 'showBySlug']);
Route::get('/search', [SearchController::class, 'index']);

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/categories', [PostController::class, 'categories']);
Route::get('/posts/slug/{slug}', [PostController::class, 'showBySlug']);
