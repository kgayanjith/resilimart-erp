<?php

use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProductViewController;
use App\Http\Controllers\Frontend\ProfileController;
use Illuminate\Support\Facades\Route;



Route::prefix('/')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/products', [ProductController::class, 'index'])->name('allproducts');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/product/{id}', [ProductViewController::class, 'index'])->name('product.view');
    Route::get('/login', [CustomerAuthController::class, 'index'])->name('login.frontend');
    Route::post('/login', [CustomerAuthController::class, 'loginfrontend'])->name('login.frontend.post');
    Route::get('/register', [CustomerAuthController::class, 'createRegister'])->name('register.frontend');
    Route::post('/register', [CustomerAuthController::class, 'register']);


    Route::middleware('auth:customer')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    });
    
});
