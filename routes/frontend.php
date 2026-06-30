<?php

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProductViewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('allproducts');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/product/{id}', [ProductViewController::class, 'index'])->name('product.view');
