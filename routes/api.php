<?php

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('product_types', ProductTypeController::class);
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::post('register', [Authcontroller::class, 'register']);
Route::post('auth', [AuthController::class, 'auth']);

Route::group([
    'middleware' => 'auth:sanctum'
], function() {
    Route::post('products', [ProductController::class, 'store']);
    Route::post('product-update/{id}', [ProductController::class, 'update']);
});

Route::resource('banners', BannerController::class);
Route::post('banner-update/{id}', [BannerController::class, 'update']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
