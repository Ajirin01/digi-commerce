<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return redirect('products');
});

// products and home page
// Route::get('/', [App\Http\Controllers\ProductController::class, 'getHomePageProducts']);
Route::get('category/{categoryId}/products', [App\Http\Controllers\ProductController::class, 'getProductsByCategory']);
Route::get('shop/{shopId}/products', [App\Http\Controllers\ProductController::class, 'getProductsByShop']);
Route::get('brand/{brandId}/products', [App\Http\Controllers\ProductController::class, 'getProductsByBrand']);
Route::get('products', [App\Http\Controllers\ProductController::class, 'getCatalogProducts']);
Route::get('search-results', [App\Http\Controllers\ProductController::class, 'searchProducts']);
Route::get('product/{id}', [App\Http\Controllers\ProductController::class, 'productDetails']);

// cart handler
Route::get('cart', [App\Http\Controllers\CartController::class, 'index']);

// order routes
Route::get('orders', [App\Http\Controllers\OrderController::class, 'getOrders'])->middleware('auth');
Route::get('order/{orderId}', [App\Http\Controllers\OrderController::class, 'getOrderDetails'])->middleware('auth');
Route::get('create-order', [App\Http\Controllers\OrderController::class, 'createOrder'])->middleware('auth');
Route::get('order-details/{id}', [App\Http\Controllers\OrderController::class, 'getOrderDetails'])->middleware('auth');

// user routes
Route::get('login', [App\Http\Controllers\UserController::class, 'loginView'])->name('shop.login');
Route::get('register', [App\Http\Controllers\UserController::class, 'registerView'])->name('register');
Route::post('login', [App\Http\Controllers\UserController::class, 'login'])->name('submitLogin');
Route::post('register', [App\Http\Controllers\UserController::class, 'register'])->name('submitRegister');
Route::post('logout', [App\Http\Controllers\UserController::class, 'logout']);



// Shipping Address routs
Route::post('shipping-address/add', [App\Http\Controllers\ShippingAddressController::class, 'addShippingAddress'])->middleware('auth');
Route::put('shipping-address/update/{id}', [App\Http\Controllers\ShippingAddressController::class, 'updateShippingAddress'])->middleware('auth');
Route::delete('shipping-address/delete/{id}', [App\Http\Controllers\ShippingAddressController::class, 'deleteShippingAddress'])->middleware('auth');
Route::get('shipping-addresses', [App\Http\Controllers\ShippingAddressController::class, 'getAllUserShippingAddresses'])->middleware('auth');
Route::get('shipping-address/{id}', [App\Http\Controllers\ShippingAddressController::class, 'getSingleUserShippingDetail'])->middleware('auth');


//  Shop routes
Route::get('shop/{id}', [App\Http\Controllers\ShopController::class, 'getShop']);
Route::get('shop/{id}/products', [App\Http\Controllers\ShopController::class, 'getShopProducts']);
Route::post('shop/products/search', [App\Http\Controllers\ShopController::class, 'searchShopProducts']);

// checkout route
Route::get('checkout', [App\Http\Controllers\CheckoutController::class, 'checkout']);
Route::post('place-order', [App\Http\Controllers\CheckoutController::class, 'placeOrder']);
Route::get('order-confirm', [App\Http\Controllers\CheckoutController::class, 'orderConfirm'])->name('order.confirm');


// account routes
// Route::get('account', [App\Http\Controllers\AccountController::class, 'dashboard']);
Route::prefix('account')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\AccountController::class, 'dashboard'])->name('account.dashboard');
    Route::get('addresses', [App\Http\Controllers\AccountController::class, 'addresses'])->name('shop.myAccount.addresses');
    Route::get('address/{id}', [App\Http\Controllers\AccountController::class, 'address']);
    Route::post('address', [App\Http\Controllers\AccountController::class, 'storeAddress']);
    Route::put('address/{id}', [App\Http\Controllers\AccountController::class, 'updateAddress']);
    Route::get('add-address', [App\Http\Controllers\AccountController::class, 'createAddress']);
    Route::get('orders', [App\Http\Controllers\AccountController::class, 'orders']);
    Route::get('order/{id}', [App\Http\Controllers\AccountController::class, 'order']);
    Route::post('update-profile', [App\Http\Controllers\AccountController::class, 'updateUserAccount'])->name('submitProfileChange');
    Route::get('profile', [App\Http\Controllers\AccountController::class, 'profile'])->name('shop.myAccount.profile');
    // Route::get('/query', [App\Http\Controllers\Api\AccountController::class, 'query']);
});
Route::get('become-seller', [App\Http\Controllers\AccountController::class, 'becomeSeller'])->middleware('auth');
Route::post('become-seller-request', [App\Http\Controllers\AccountController::class, 'becomeSellerRequest'])->middleware('auth');


// wishlist route
Route::get('wish-list', [App\Http\Controllers\WishListController::class, 'index'])->middleware('auth');


// contact routes
Route::get('contact', [App\Http\Controllers\ContactController::class, 'contact']);
Route::post('contact', [App\Http\Controllers\ContactController::class, 'sendMessage']);


// admin routes
Route::prefix('admin')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('dashboard')->middleware('admin');
    Route::get('product-create-options', [App\Http\Controllers\Admin\ProductsController::class, 'createOption'])->middleware('product')->name('product.create.options');
    Route::get('product-bulk-update-options', [App\Http\Controllers\Admin\ProductsController::class, 'bulkUpdateOption'])->middleware('product')->name('product.bulk.update.options');
    Route::resource('products', App\Http\Controllers\Admin\ProductsController::class)->middleware('product');
    Route::get('products-bulk-edit',	[App\Http\Controllers\Admin\ProductsController::class, 'productBulkEditCreate'])->middleware('product')->name('product-bulk-edit');
    Route::post('products-bulk-edit',	[App\Http\Controllers\Admin\ProductsController::class, 'productBulkEditStore'])->middleware('product')->name('product-bulk-edit');
    Route::get('order/{type}',	[App\Http\Controllers\Admin\OrdersController::class, 'getOrdersByType'])->name('orders_by_type')->middleware('order');
    Route::get('order-details/{order}',	[App\Http\Controllers\Admin\OrdersController::class, 'orderDetails'])->name('order_details')->middleware('order');
    Route::post('update_order_status/{order}', [App\Http\Controllers\Admin\OrdersController::class, 'updateOrderStatus'])->name('update_order_status')->middleware('order');
    Route::resource('brands', App\Http\Controllers\Admin\BrandsController::class)->middleware('product');
    Route::resource('sellers', App\Http\Controllers\Admin\SellerController::class)->middleware('admin');
    Route::resource('shops', App\Http\Controllers\Admin\ShopController::class)->middleware('admin');
    Route::resource('users', App\Http\Controllers\Admin\UsersController::class)->middleware('admin');
    Route::resource('categories', App\Http\Controllers\Admin\CategoriesController::class)->middleware('product');
    Route::get('admin-login', [App\Http\Controllers\Admin\AuthController::class, 'loginForm'])->name('admin-login');
    Route::post('admin-login-handle', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login');
    Route::post('admin-logut', function(){
        Auth::logout();
        return redirect()->route('admin-login');
    })->name('admin-logout');
}); 