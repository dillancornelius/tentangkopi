<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Area pelanggan (admin otomatis diarahkan ke dashboard)
Route::middleware('customer')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('menu', [MenuController::class, 'index'])->name('menu.index');
    Route::view('about-us', 'about-us')->name('about.us');
    Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');

    // Keranjang (JSON), boleh diakses tamu
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'show'])->name('show');
        Route::delete('/', [CartController::class, 'clear'])->name('clear');
        Route::post('items', [CartController::class, 'add'])->name('add');
        Route::patch('items/{menu}', [CartController::class, 'update'])->name('update');
    });

    Route::middleware('auth')->group(function () {
        Route::get('checkout', [CheckoutController::class, 'show'])->name('checkout.show');
        Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');

        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::get('reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
        Route::put('reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    });
});

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', Admin\DashboardController::class)->name('dashboard');
    Route::get('orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::patch('orders/{order}', [Admin\OrderController::class, 'update'])->name('orders.update');
    Route::resource('users', Admin\UserController::class)->except('show');
    Route::resource('menus', Admin\MenuController::class)->except('show');
});
