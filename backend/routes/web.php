<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAddressController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminProductReviewController;
use App\Http\Controllers\Admin\AdminPostReviewController; // <-- THÊM MỚI
use App\Http\Controllers\Admin\AdminStatisticalController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\client\AuthController;
use App\Http\Controllers\Admin\AdminStyleController;

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logon', [AdminController::class, 'formLogon'])->name('formLogon');
Route::post('/logon', [AdminController::class, 'logon'])->name('logon');

Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    // ... các route khác của bạn (ckeditor, config, password...) giữ nguyên ...
    Route::post('/uploads-ckeditor', [AdminController::class, 'ckeditorImage']);
    Route::get('/file-browser', [AdminController::class, 'fileBrowser']);
    Route::get('/configs', [AdminController::class, 'config'])->name('admin.config');
    Route::post('/configs', [AdminController::class, 'updateConfig'])->name('admin.config.update');
    Route::get('/doi-mat-khau/{adminId}', [AdminController::class, 'formChangePassword'])->name('admin.password.change');
    Route::post('/doi-mat-khau/{adminId}', [AdminController::class, 'changePassword'])->name('admin.password.update');
    Route::prefix('/thong-ke')->group(function () {
        Route::get('/doanh-thu', [AdminStatisticalController::class, 'getRevenueData'])->name('admin.statistical.revenue');
    });

    // === QUẢN LÝ DANH MỤC SẢN PHẨM (Đã hoàn tác về cấu trúc cũ) ===
    Route::prefix('danh-muc-san-pham')->group(function () {
        Route::get('/', [AdminCategoryController::class, 'index'])->name('admin.category.product');
        Route::post('/change-status', [AdminCategoryController::class, 'changeStatus'])->name('admin.category.product.change-status');
        Route::get('/them-danh-muc', [AdminCategoryController::class, 'create'])->name('admin.category.product.add');
        Route::post('/them-danh-muc', [AdminCategoryController::class, 'store'])->name('admin.category.product.store');
        Route::get('/sua-danh-muc/{categoryId}', [AdminCategoryController::class, 'edit'])->name('admin.category.product.edit');
        Route::post('/update', [AdminCategoryController::class, 'update'])->name('admin.category.product.update');
        Route::post('/xoa-danh-muc/{categoryId}', [AdminCategoryController::class, 'destroy'])->name('admin.category.product.delete');
    });

    // === QUẢN LÝ KIỂU DÁNG (Đã tối ưu) ===
    // Route này sẽ tự động tạo ra admin.styles.index, admin.styles.create, ...
    Route::resource('styles', AdminStyleController::class)->names('admin.styles');

    // ... các route khác của bạn (sản phẩm, bình luận, bài viết...) giữ nguyên ...
    Route::prefix('san-pham')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('admin.product');
        Route::get('/them-san-pham', [AdminProductController::class, 'addProduct'])->name('admin.product.add');
        Route::post('/them-san-pham', [AdminProductController::class, 'storeProduct'])->name('admin.product.store');
        Route::get('/sua-san-pham/{productId}', [AdminProductController::class, 'editProduct'])->name('admin.product.edit');
        Route::post('/sua-san-pham/{productId}', [AdminProductController::class, 'updateProduct'])->name('admin.product.update');
        Route::post('/change-status', [AdminProductController::class, 'changeStatus'])->name('admin.product.change-status');
        Route::delete('/xoa-san-pham/{product}', [AdminProductController::class, 'deleteProduct'])->name('admin.product.delete');
        Route::get('/doanh-thu', [AdminProductController::class, 'revenue'])->name('admin.product.revenue');
        Route::get('/json/{productId}', [AdminProductController::class, 'getProductJson'])->name('admin.product.json');
        Route::get('/get-styles-by-category', [AdminProductController::class, 'getStylesByCategory'])->name('admin.getStylesByCategory');
    });

    Route::prefix('binh-luan')->group(function () {
        Route::get('/', [AdminProductReviewController::class, 'index'])->name('admin.comment');
        Route::post('/change-status', [AdminProductReviewController::class, 'changeStatus'])->name('admin.comment.change-status');
        Route::post('/xoa-binh-luan/{reviewId}', [AdminProductReviewController::class, 'deleteComment']);
        Route::get('/sua-binh-luan/{reviewId}', [AdminProductReviewController::class, 'editReview'])->name('admin.comment.edit');
        Route::post('/sua-binh-luan/{reviewId}', [AdminProductReviewController::class, 'updateReview'])->name('admin.comment.update');
    });

    Route::prefix('danh-muc-bai-viet')->group(function () {
        Route::get('/', [AdminPostController::class, 'index'])->name('admin.category.post');
        Route::get('/them-danh-muc', [AdminPostController::class, 'addCategory'])->name('admin.category.post.add');
        Route::post('/them-danh-muc', [AdminPostController::class, 'storeCategory'])->name('admin.category.post.store');
        Route::post('/change-status', [AdminPostController::class, 'changeStatus'])->name('admin.category.post.change-status');
        Route::get('/sua-danh-muc/{categoryId}', [AdminPostController::class, 'editCategory'])->name('admin.category.post.edit');
        Route::post('/sua-danh-muc/{categoryId}', [AdminPostController::class, 'updateCategory'])->name('admin.category.post.update');
        Route::post('/xoa-danh-muc/{categoryId}', [AdminPostController::class, 'deleteCategory'])->name('admin.category.post.delete');
    });

    Route::prefix('bai-viet')->group(function () {
        Route::get('/', [AdminPostController::class, 'post'])->name('admin.post');
        Route::post('/change-status', [AdminPostController::class, 'changeStatusPost'])->name('admin.post.change-status');
        Route::get('/them-bai-viet', [AdminPostController::class, 'addPost'])->name('admin.post.add');
        Route::post('/them-bai-viet', [AdminPostController::class, 'storePost'])->name('admin.post.store');
        Route::get('/sua-bai-viet/{post}', [AdminPostController::class, 'editPost'])->name('admin.post.edit');
        Route::put('/sua-bai-viet/{post}', [AdminPostController::class, 'updatePost'])->name('admin.post.update');
        Route::delete('/xoa-bai-viet/{post}', [AdminPostController::class, 'deletePost'])->name('admin.post.delete');
    });

    // === QUẢN LÝ BÌNH LUẬN BÀI VIẾT (THÊM MỚI) ===
    Route::prefix('post-review')->name('admin.post-review.')->group(function () {
        Route::get('/', [AdminPostReviewController::class, 'index'])->name('list');
        Route::get('/edit/{reviewId}', [AdminPostReviewController::class, 'edit'])->name('edit');
        Route::put('/update/{reviewId}', [AdminPostReviewController::class, 'update'])->name('update');
        Route::delete('/delete/{reviewId}', [AdminPostReviewController::class, 'destroy'])->name('delete');
    });

    Route::prefix('don-hang')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('admin.order');
        Route::post('/change-status', [AdminOrderController::class, 'changeStatus'])->name('admin.order.change-status');
        Route::get('/chi-tiet/{orderId}', [AdminOrderController::class, 'detailOrder'])->name('admin.order.detail');
        Route::post('/xoa-don-hang/{orderId}', [AdminOrderController::class, 'deleteOrder']);
    });

    Route::prefix('khach-hang')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.user');
        Route::get('/xem-chi-tiet/{userId}', [AdminUserController::class, 'userDetail'])->name('admin.user.detail');
    });

    Route::prefix('dia-chi')->group(function () {
        Route::get('/tinh-thanh', [AdminAddressController::class, 'province'])->name('admin.address.province');
        Route::get('/quan-huyen', [AdminAddressController::class, 'district'])->name('admin.address.district');
        Route::get('/sua-tinh-thanh/{provinceId}', [AdminAddressController::class, 'editProvince'])->name('admin.address.province.edit');
        Route::post('/sua-tinh-thanh/{provinceId}', [AdminAddressController::class, 'updateProvince'])->name('admin.address.province.update');
        Route::get('/them-tinh-thanh', [AdminAddressController::class, 'addProvince'])->name('admin.address.province.add');
        Route::post('/them-tinh-thanh', [AdminAddressController::class, 'storeProvince'])->name('admin.address.province.store');
        Route::post('/xoa-dia-chi/{address}/{addressId}', [AdminAddressController::class, 'deleteAddress']);
        Route::get('/them-quan-huyen', [AdminAddressController::class, 'addDistrict'])->name('admin.address.district.add');
        Route::post('/them-quan-huyen', [AdminAddressController::class, 'storeDistrict'])->name('admin.address.district.store');
        Route::get('/sua-quan-huyen/{districtId}', [AdminAddressController::class, 'editDistrict'])->name('admin.address.district.edit');
        Route::post('/sua-quan-huyen/{districtId}', [AdminAddressController::class, 'updateDistrict'])->name('admin.address.district.update');
    });
});
