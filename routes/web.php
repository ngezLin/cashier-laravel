<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Cashier\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Cashier\TransactionController;
use App\Http\Controllers\Cashier\CashierProductController;
use App\Http\Controllers\public\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('welcome');


// Authentication
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin-only routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
});

// Cashier-only routes
Route::middleware(['auth', 'role:cashier'])->prefix('cashier')->name('cashier.')->group(function () {
    Route::get('/dashboard', fn() => view('cashier.dashboard'))->name('dashboard');
    Route::get('/products-list', [CartController::class, 'showProducts'])->name('products.list');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/{id}/update', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // ✅ Fitur Draft
    Route::post('/cart/save-draft', [CartController::class, 'saveDraft'])->name('cart.saveDraft');
    Route::get('/transactions/drafts', [CartController::class, 'showDrafts'])->name('transactions.drafts');
    Route::post('/cart/load-draft/{id}', [CartController::class, 'loadDraft'])->name('cart.loadDraft');

    Route::get('/transaction-success/{transaction}', [CartController::class, 'transactionSuccess'])->name('transactions.success');
    Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
    Route::post('/transactions/{transaction}/refund', [TransactionController::class, 'refund'])->name('transactions.refund');
    Route::get('/cart/draft', [CartController::class, 'viewDraft'])->name('cart.draft');

    //crud product for cashier
    Route::resource('products', CashierProductController::class);

});

