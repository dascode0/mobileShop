<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::get('/', [AuthenticationController::class, 'home'])->name('home');

Route::get('/navbar', function () {
    return view('navbar');
})->name('navbar');
Route::post('/register', [AuthenticationController::class, 'register'])->name('registerSave');

Route::post('/login', [AuthenticationController::class, 'login'])->name('loginSave');
// Named 'login' so Laravel's default auth-middleware redirect has somewhere to go
// for guests who hit a protected customer page instead of throwing a routing error.
Route::get('/login', function () {
    return redirect()->route('home');
})->name('login');
Route::get('/account', [AuthenticationController::class, 'account'])->middleware('auth')->name('account');
Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout');

Route::get('/admin', function () {
    return view('admin-login');
})->name('admin.login');

Route::post('admin_login', [AuthenticationController::class, 'adminLogin'])->name('admin.login.save');
Route::post('admin_register', [AuthenticationController::class, 'adminRegister'])->name('admin.register.save');
Route::get('admin_logout', [AuthenticationController::class, 'adminLogout'])->name('admin.logout');

// Admin-only Routes ***************************************************************************
// Everything in this group requires a logged-in user with is_admin = true.
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AuthenticationController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AuthenticationController::class, 'users'])->name('users');

    // Category Routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/category-add', [CategoryController::class, 'catagory_add'])->name('category.add');
    Route::post('category-save', [CategoryController::class, 'create'])->name('category.save');
    Route::get('/category-edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category-update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category-delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

    // Product management Routes (product-show below stays public for customers)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/product-add', [ProductController::class, 'create'])->name('product.add');
    Route::post('/product-save', [ProductController::class, 'store'])->name('product.save');
    Route::get('product-update/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('product-update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('product-delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');

    // Order management Routes
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/admin/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});
// End of Admin-only Routes ********************************************************************

// product-show stays public — customers browse product pages without logging in
Route::get('product-show/{id}', [ProductController::class, 'show'])->name('product.show');

/*user routes start */

// home page route

Route::get('home', [AuthenticationController::class, 'home'])->name('home');


//cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{product_id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/add/{product_id}', [CartController::class, 'addToCart'])->name('cart.add.post');
Route::post('/cart/{product_id}/quantity', [CartController::class, 'quantityUpdate'])->name('cart.updateQuantity');
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clearAll'])->name('cart.clearAll');

// shop route
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// about route
Route::get('/about', [PageController::class, 'about'])->name('about.page');
Route::get('/news', [PageController::class, 'news'])->name('news.page');
Route::get('/contact-us', [PageController::class, 'contact'])->name('contact.page');

//wishlist routes
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/like-product/{productId}', [WishlistController::class, 'wishProduct'])->name('wishlist.add');
Route::post('/unlike-product/{id}', [WishlistController::class, 'unwishProduct'])->name('wishlist.remove');

// checkout routes
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/cart-items', [CheckoutController::class, 'getCartItems'])->name('checkout.cart-items');
    Route::get('/checkout/order-summary', [CheckoutController::class, 'getOrderSummary'])->name('checkout.order-summary');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
});

// address routes
Route::middleware('auth')->group(function () {
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{id}', [AddressController::class, 'show'])->name('addresses.show');
    Route::put('/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
});
