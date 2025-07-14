<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\DB;

Route::get('/products/category/{category}', [ProductController::class, 'getByCategory']);
Route::get('/products/category/{category}/{style?}', [ProductController::class, 'getByCategoryAndStyle']);
Route::get('/products/top', [ProductController::class, 'getByIsOnTop']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::resource('users', UserController::class);
Route::apiResource('products', ProductController::class);
Route::get('/debug-db', function () {
    return DB::select('SELECT DATABASE() as db_name');
});
Route::get('/debug-products', function () {
    return DB::table('products')->get();
});
