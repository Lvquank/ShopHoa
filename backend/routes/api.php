<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\AuthController;
use Illuminate\Support\Facades\DB;

Route::prefix('products')->group(function () {
    Route::get('category/{category}', [ProductController::class, 'getByCategory']);
    Route::get('category/{category}/{style?}', [ProductController::class, 'getByCategoryAndStyle']);
    Route::get('top', [ProductController::class, 'getByIsOnTop']);
    Route::get('search', [ProductController::class, 'search']);
    Route::get('{id}', [ProductController::class, 'show']);
    Route::get('/', [ProductController::class, 'index']);
});
// Client Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/check', [AuthController::class, 'check']);
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('/reset-password/{token}', [AuthController::class, 'resetPassword']);
    });
});

// Admin Authentication Routes
Route::prefix('admin/auth')->group(function () {
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout']);
});

Route::get('/debug-db', function () {
    return DB::select('SELECT DATABASE() as db_name');
});
Route::get('/debug-products', function () {
    return DB::table('products')->get();
});
Route::get('/debug-middleware', function () {
    return response()->json([
        'route_middleware' => request()->route()->middleware(),
        'global_middleware' => app('router')->getMiddleware(),
        'current_route' => request()->route()->getName(),
        'uri' => request()->getRequestUri(),
    ]);
});
// Trong routes/api.php
Route::any('/debug-request', function () {
    return response()->json([
        'url' => request()->url(),
        'path' => request()->path(),
        'method' => request()->method(),
        'route_name' => request()->route() ? request()->route()->getName() : null,
        'middleware' => request()->route() ? request()->route()->middleware() : null,
        'full_url' => request()->fullUrl(),
        'headers' => request()->headers->all(),
    ]);
});
