<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\SocialiteController; // Giả sử bạn sẽ tạo Controller này

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Các route khác của bạn...
Route::get('/', function () {
    return ['Laravel' => app()->version()];
});


// === ROUTE CHO ĐĂNG NHẬP MẠNG XÃ HỘI ===

// Route này sẽ chuyển hướng người dùng đến trang đăng nhập của Google
Route::get('/auth/google/redirect', [SocialiteController::class, 'redirectToGoogle'])->name('google.redirect');

// Route này Google sẽ gọi lại sau khi người dùng xác thực thành công
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('google.callback');

// Tương tự cho Facebook
Route::get('/auth/facebook/redirect', [SocialiteController::class, 'redirectToFacebook'])->name('facebook.redirect');
Route::get('/auth/facebook/callback', [SocialiteController::class, 'handleFacebookCallback'])->name('facebook.callback');
