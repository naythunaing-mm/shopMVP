<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopOwnerProfileController;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

/**
 * Shop Owner Profile Routes
 */
Route::middleware(['auth'])
    ->prefix('shop-owner')
    ->name('shop-owner.')
    ->group(function () {
        Route::get('/dashboard', [ShopOwnerProfileController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [ShopOwnerProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [ShopOwnerProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ShopOwnerProfileController::class, 'update'])->name('profile.update');
    });

/**
 * Shop Routes (Admin Only)
 */
Route::prefix('shop')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/', [ShopController::class, 'index'])->name('shop.index');
        Route::get('/create', [ShopController::class, 'create'])->name('shop.create');
        Route::get('/{shop}', [ShopController::class, 'show'])->name('shop.show');
        Route::get('/{shop}/edit', [ShopController::class, 'edit'])->name('shop.edit');
        Route::post('/', [ShopController::class, 'store'])->name('shop.store');
        Route::put('/{shop}', [ShopController::class, 'update'])->name('shop.update');
        Route::delete('/{shop}', [ShopController::class, 'destroy'])->name('shop.destroy');
    });

/**
 * Test Route for Product
 */
Route::get('/product/test', function () {
    App\Models\Product::first()->update(['colors' => 'red,blue,green']);
    return redirect()->back();
})->name('product.test');

/**
 * Authenticated Routes
 */
Route::middleware(['auth'])->group(function () {
    Route::resource('category', \App\Http\Controllers\CategoryController::class);
    Route::resource('product', ProductController::class);
});

/**
 * Shop Owner Dashboard
 */
Route::get('dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'role:shop-owner'])
    ->name('dashboard');

/**
 * Orders Routes
 */
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');

    Route::patch('/orders/{order}/accept', [OrderController::class, 'accept'])->name('order.accept');
    Route::patch('/orders/{order}/reject', [OrderController::class, 'reject'])->name('order.reject');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
});

/**
 * Admin Routes for Product Visibility
 */
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/products/visibility', [App\Http\Controllers\Admin\ProductVisibilityController::class, 'index'])->name('products.visibility');
        Route::post('/products/{product}/toggle-status', [App\Http\Controllers\Admin\ProductVisibilityController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::post('/products/{product}/toggle-featured', [App\Http\Controllers\Admin\ProductVisibilityController::class, 'toggleFeatured'])->name('products.toggle-featured');
    });
