<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\GoogleController;
use App\Http\Controllers\Client\CartController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\LocationController;
use App\Http\Controllers\Client\ProductReviewController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\PostReviewController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\StyleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//======================================================================
// PUBLIC ROUTES (Không cần đăng nhập)
//======================================================================

// --- Product Routes ---
Route::prefix('products')->group(function () {
    // Các route tĩnh nên được đặt ở trên
    Route::get('/', [ProductController::class, 'index']);
    Route::get('top', [ProductController::class, 'getByIsOnTop']);
    Route::get('new', [ProductController::class, 'getNewProducts']); // Đã di chuyển lên đây
    Route::get('search', [ProductController::class, 'search']);
    Route::get('category/{category}', [ProductController::class, 'getByCategory']);
    Route::get('category/{category}/{style?}', [ProductController::class, 'getByCategoryAndStyle']);
    Route::get('{id}', [ProductController::class, 'show']);
});

// --- Authentication Routes ---
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::get('/reset-password/{token}', [AuthController::class, 'validateResetToken']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/google/callback', [GoogleController::class, 'handleGoogleCallbackApi']);
});

// --- Category Routes ---
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/styles', [CategoryController::class, 'getStyles']);
Route::get('/categories/{category_alias}/{style_alias?}', [CategoryController::class, 'show']);
// --- Location Routes ---
Route::get('/get-districts/{provinceId}', [LocationController::class, 'getDistricts']);
Route::get('/get-wards/{districtId}', [LocationController::class, 'getWards']);
// --- Product Review Routes ---
Route::get('products/{product}/reviews', [ProductReviewController::class, 'index']);
// --- Post Routes ---
Route::apiResource('posts', PostController::class);
//======================================================================
// PROTECTED ROUTES (Cần đăng nhập - auth:sanctum)
//======================================================================

Route::middleware('auth:sanctum')->group(function () {

    // --- Authenticated User Routes ---
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/check', [AuthController::class, 'check']);
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });

    // --- Cart Routes ---
    Route::prefix('cart')->group(function () {
        // SỬA LỖI: Đổi đường dẫn từ '/' thành '/show' để khớp với frontend
        // GET /api/cart/show
        Route::get('/show', [CartController::class, 'show']);

        // POST /api/cart/add
        Route::post('/add', [CartController::class, 'add']);

        // POST /api/cart/update
        Route::post('/update', [CartController::class, 'update']);

        // POST /api/cart/remove
        Route::post('/remove', [CartController::class, 'remove']);
    });
    // --- Checkout & Order Routes ---
    Route::get('/checkout', [CheckoutController::class, 'getCheckoutData']);
    Route::post('/order', [CheckoutController::class, 'placeOrder']);
    // --- Admin Routes (Ví dụ) ---
    // --- Product Review Routes ---
    Route::post('products/{product}/reviews', [ProductReviewController::class, 'store']);
    Route::put('reviews/{review}', [ProductReviewController::class, 'update']);
    Route::delete('reviews/{review}', [ProductReviewController::class, 'destroy']);
    Route::post('/post-reviews', [PostReviewController::class, 'store']);
});


//======================================================================
// DEBUG ROUTES (Chỉ dùng để kiểm tra)
//======================================================================
Route::get('/debug-db', fn() => DB::select('SELECT DATABASE() as db_name'));
Route::get('/debug-products', fn() => DB::table('products')->get());
Route::any('/debug-request', function () {
    return response()->json([
        'url' => request()->url(),
        'path' => request()->path(),
        'method' => request()->method(),
        'headers' => request()->headers->all(),
        'user' => request()->user() // Thêm dòng này để kiểm tra user đã xác thực chưa
    ]);
});
