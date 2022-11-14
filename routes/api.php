<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CheckOutController;
use App\Http\Controllers\Api\NotificationHandlerController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RajaOngkirController;
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

    Route::get('/order', [OrderController::class, 'index'])->name('oder.index');
    Route::get('/order/{snap_token}', [OrderController::class, 'show']);

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::get('/cart/total', [CartController::class, 'getCartTotal'])->name('cart.getCartTotal');
    Route::get('/cart/totalWeight', [CartController::class, 'getCartTotalWeight'])->name('cart.getCartTotalWeight');
    Route::post('/cart/remove', [CartController::class, 'removeCart'])->name('cart.removeCart');

    Route::get('/rajaongkir/provinces', [RajaOngkirController::class, 'getProvinces'])->name('rajaongkir.getProvinces');
    Route::get('/rajaongkir/cities', [RajaOngkirController::class, 'getCities'])->name('rajaongkir.getCities');
    Route::post('/rajaongkir/checkOngkir', [RajaOngkirController::class, 'checkOngkir'])->name('rajaongkir.checkOngkir');

    Route::post('/checkout', [CheckOutController::class, 'store'])->name('checkOut.store');

    Route::post('/notificationHandler', [NotificationHandlerController::class, 'notificationHandler']);
});


Route::prefix('v1')->group(function () {

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{slug}', [CategoryController::class, 'show']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{slug}', [ProductController::class, 'show']);

    Route::get('/sliders', [SliderController::class, 'index']);
});