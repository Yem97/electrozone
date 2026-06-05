<?php

use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\EquipmentsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();

        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return redirect()->route('home');
        } else {
            return redirect()->route('shop.index');
        }
    }

    return view('auth.login');
});

// Auth routes (login, register, forgot password, etc.)
Auth::routes();

// Public routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
    
    Route::resource("users",UserController::class);


    Route::resource("equipments",EquipmentsController::class);
    // routes/web.php
    Route::get('/equipments/catalog/download', [EquipmentsController::class, 'downloadCatalog'])->name('equipments.catalog.download');


Route::resource('orders', OrderController::class);


    
    Route::resource('categories', CategoriesController::class);


    Route::resource("roles", RoleController::class);
    
    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/thankyou', [CheckoutController::class, 'thankYou'])->name('checkout.thankyou');

    Route::get('/adminorders', [AdminOrderController::class, 'index'])->name('adminorders.index');
    Route::get('/adminorders/{order}', [AdminOrderController::class, 'show'])->name('adminorders.show');
    Route::patch('/adminorders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('adminorders.updateStatus');

   });
