<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

Route::get('/products/category/{category}', [ProductController::class, 'getByCategory']);
Route::get('/products/category/{category}/{style?}', [ProductController::class, 'getByCategoryAndStyle']);
Route::get('/products/top', [ProductController::class, 'getByIsOnTop']);
Route::resource('users', UserController::class);
Route::apiResource('products', ProductController::class);
