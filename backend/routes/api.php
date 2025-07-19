<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\GoogleController;
use App\Http\Controllers\Client\CartController;
use Illuminate\Support\Facades\DB;

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
    Route::get('/', [ProductController::class, 'index']);
    Route::get('category/{category}', [ProductController::class, 'getByCategory']);
    Route::get('category/{category}/{style?}', [ProductController::class, 'getByCategoryAndStyle']);
    Route::get('top', [ProductController::class, 'getByIsOnTop']);
    Route::get('search', [ProductController::class, 'search']);
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

// --- Admin Authentication Routes ---
Route::prefix('admin/auth')->group(function () {
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
});


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

    // --- Admin Routes (Ví dụ) ---
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        // Đặt các route của admin cần xác thực ở đây
        Route::post('/auth/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout']);
    });
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
