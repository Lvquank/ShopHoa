<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    // Mặc định, route này có thể trả về một view.
    // Đối với API, trả về phiên bản Laravel như thế này cũng là một cách hay để kiểm tra.
    return ['Laravel' => app()->version()];
});
