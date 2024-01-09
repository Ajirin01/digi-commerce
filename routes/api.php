<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// routes/api.php


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('sellers')->group(function () {
    Route::get('query', [App\Http\Controllers\Api\SellerController::class, 'query']);
    Route::post('', [App\Http\Controllers\Api\SellerController::class, 'create']);
    Route::put('/{id}', [App\Http\Controllers\Api\SellerController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\SellerController::class, 'destroy']);
});

// Withdrawal routes
Route::prefix('withdrawals')->group(function () {
    Route::get('/query', [App\Http\Controllers\Api\WithdrawalController::class, 'query']);
    Route::post('/', [App\Http\Controllers\Api\WithdrawalController::class, 'create']);
    Route::put('/{id}', [App\Http\Controllers\Api\WithdrawalController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\WithdrawalController::class, 'delete']);
});

// Product routes
Route::prefix('products')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\ProductController::class, 'index']);
    Route::post('/', [App\Http\Controllers\Api\ProductController::class, 'create']);
    Route::put('/{id}', [App\Http\Controllers\Api\ProductController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\ProductController::class, 'destroy']);
});
Route::get('/query-products', [App\Http\Controllers\Api\ProductController::class, 'query']);



// Shop routes
Route::prefix('shops')->group(function () {
    // Route::get('/', [App\Http\Controllers\Api\ShopController::class, 'index']);
    // Route::get('/{id}', [App\Http\Controllers\Api\ShopController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\ShopController::class, 'create']);
    Route::put('/{id}', [App\Http\Controllers\Api\ShopController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\ShopController::class, 'destroy']);
    Route::get('/query', [App\Http\Controllers\Api\ShopController::class, 'query']);
});

// Order routes
Route::prefix('orders')->group(function () {
    Route::post('/', [App\Http\Controllers\Api\OrderController::class, 'store']);
    Route::put('/{id}', [App\Http\Controllers\Api\OrderController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\OrderController::class, 'destroy']);
    Route::get('/query', [App\Http\Controllers\Api\OrderController::class, 'query']);
});

// Shipping address routes
Route::prefix('shipping')->group(function () {
    Route::post('/manage-address', [App\Http\Controllers\Api\ShippingAddressController::class, 'manageShippingAddress']);
    Route::delete('/delete-address/{id}', [App\Http\Controllers\Api\ShippingAddressController::class, 'deleteShippingAddress']);
    Route::get('/query', [App\Http\Controllers\Api\ShippingAddressController::class, 'query']);
});

Route::prefix('users')->group(function () {
    Route::post('/', [App\Http\Controllers\Api\UserController::class, 'create']);
    Route::post('/register', [App\Http\Controllers\Api\UserController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\Api\UserController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Api\UserController::class, 'logout']);
    Route::put('/{id}', [App\Http\Controllers\Api\UserController::class, 'update']);
    // Route::delete('/{id}', [App\Http\Controllers\Api\UserController::class, 'destroy']);
    Route::get('/query', [App\Http\Controllers\Api\UserController::class, 'query']);
});

// Earning routes
Route::prefix('earnings')->group(function () {
    Route::get('/query', [App\Http\Controllers\Api\EarningController::class, 'query']);
    Route::post('/create', [App\Http\Controllers\Api\EarningController::class, 'create']);
    Route::put('/update/{id}', [App\Http\Controllers\Api\EarningController::class, 'update']);
    Route::delete('/delete/{id}', [App\Http\Controllers\Api\EarningController::class, 'delete']);
});

// Brand routes
Route::prefix('brands')->group(function () {
    Route::get('/query', [App\Http\Controllers\Api\BrandController::class, 'query']);
    Route::post('', [App\Http\Controllers\Api\BrandController::class, 'create']);
    Route::put('/{id}', [App\Http\Controllers\Api\BrandController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\BrandController::class, 'destroy']);
});

// Category routes
Route::prefix('categories')->group(function () {
    Route::get('/query', [App\Http\Controllers\Api\CategoryController::class, 'query']);
    Route::post('/', [App\Http\Controllers\Api\CategoryController::class, 'store']);
    Route::put('/{id}', [App\Http\Controllers\Api\CategoryController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\CategoryController::class, 'destroy']);
});


Route::prefix('carts')->group(function () {
    Route::get('/query', [App\Http\Controllers\Api\CartController::class, 'query']);
    Route::post('/manage', [App\Http\Controllers\Api\CartController::class, 'manageCart']);
    // Route::post('/add-to-cart', [App\Http\Controllers\Api\CartController::class, 'addToCart'])->name('add-to-cart');
    Route::post('/update/all', [App\Http\Controllers\Api\CartController::class, 'updateCarts']);
    Route::delete('/{id}', [App\Http\Controllers\Api\CartController::class, 'removeCartItem']);
});
Route::post('/add-to-cart', [App\Http\Controllers\Api\CartController::class, 'addToCart'])->name('add-to-cart');

// product review
// Route::apiResource('product-reviews', App\Http\Controllers\Api\ProductReviewController::class);
Route::prefix('product-reviews')->group(function () {
    Route::post('/', [App\Http\Controllers\Api\ProductReviewController::class, 'store']);
    Route::put('/{id}', [App\Http\Controllers\Api\ProductReviewController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\ProductReviewController::class, 'destroy']);
    Route::get('/query', [App\Http\Controllers\Api\ProductReviewController::class, 'query']);
});

// wishlist review
Route::prefix('wish-list')->group(function () {
    Route::post('/', [App\Http\Controllers\Api\WishListController::class, 'store']);
    Route::put('/{id}', [App\Http\Controllers\Api\WishListController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\WishListController::class, 'destroy']);
    Route::get('/query', [App\Http\Controllers\Api\WishListController::class, 'query']);
});