<?php

use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProductViewController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Mail\OrderPlaceMail;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;



Route::prefix('/')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/products', [ProductController::class, 'index'])->name('allproducts');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/product/{id}', [ProductViewController::class, 'index'])->name('product.view');
    Route::get('/login', [CustomerAuthController::class, 'index'])->name('login.frontend');
    Route::post('/login', [CustomerAuthController::class, 'loginfrontend'])->name('login.frontend.post');
    Route::get('/register', [CustomerAuthController::class, 'createRegister'])->name('register.frontend');
    Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.frontend.post');
    Route::get('/about-us', [PageController::class, 'aboutus'])->name('aboutus');
    Route::get('/categories', [PageController::class, 'categoryPage'])->name('category.view');
    Route::get('/categories/products/{id}', [PageController::class, 'findProduct'])->name('category.product');
    // Route::get('/test-mail', function () {
    //     $user = Customer::latest();

    //    dd($user);

    //     if (! $user) {
    //         return 'No orders found in database.';
    //     }

    //     return view('emails.register', ['user' => $user]);
    // });


    Route::middleware('auth:customer')->group(function () {
        Route::post('/logout', [CustomerAuthController::class, 'logoutfrontend'])->name('logout.frontend');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::get('/cart/checkout', [CartController::class, 'checkoutPage'])->name('checkout');
        Route::post('/cart/checkout', [OrderController::class, 'store'])->name('checkout.store');
        Route::get('/orders', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/orders/{id}', [OrderController::class, 'trackOrder'])->name('order.track');
        Route::patch('/orders/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');
        Route::get('/cart/checkout/intent/{order}', [PaymentController::class, 'show'])->name('payment.show');
        Route::get('/payment-success', [PaymentController::class, 'success'])->name('payment.success');
    });
});
