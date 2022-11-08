<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('/category', CategoryController::class);
    Route::resource('/product', ProductController::class);
    Route::resource('/user', UserController::class);
    Route::get('/slider', [\App\Http\Controllers\SliderController::class, 'index'])->name('slider.index');
    Route::post('/slider/create', [\App\Http\Controllers\SliderController::class, 'store'])->name('slider.store');
    Route::delete('/slider/{id?}', [\App\Http\Controllers\SliderController::class, 'destroy'])->name('slider.destroy');
    Route::get('/customer', [\App\Http\Controllers\CustomerController::class, 'index'])->name('customer.index');
    Route::resource('/order', OrderController::class, ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);
});