<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// midleware
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', [AuthController::class, 'getUser'])->name('auth.getUser');
    Route::post('/logout', [AuthController::class, 'logout'])->name('atuh.logout');
    // Route::get('/order', [OrderController::class, 'index', ['as' => 'customer']]);
    // Route::get('/order/{snap_token?}', [OrderController::class, 'show', ['as' => 'customer']]);
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    //     Route::get('/cart/total', [CartController::class, 'getCartTotal', ['as' => 'customer']]);
    //     Route::get('/cart/totalWeight', [CartController::class, 'getCartTotalWeight', ['as' => 'customer']]);
    //     Route::post('/cart/remove', [CartController::class, 'removeCart', ['as' => 'customer']]);
    //     Route::post('/cart/removeAll', [CartController::class, 'removeAllCart', ['as' => 'customer']]);
});



Route::prefix('v1')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{slug}', [CategoryController::class, 'show']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{slug}', [ProductController::class, 'show']);
    Route::get('/sliders', [SliderController::class, 'index']);
});