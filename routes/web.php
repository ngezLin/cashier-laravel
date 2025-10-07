<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Cashier\TransactionController as CashierTransactionController;
use App\Http\Controllers\Cashier\CashierProductController;
use App\Http\Controllers\public\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('welcome');

// Authentication
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ====================== Admin Routes ======================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', ProductController::class);
    Route::post('products/import', [ProductController::class, 'import'])->name('products.import');
    Route::get('/products-list', [AdminTransactionController::class, 'showProducts'])->name('products.list');

    // Products & Cart
    Route::get('/products-list', [AdminTransactionController::class, 'showProducts'])->name('products.list');
    Route::get('/cart', [AdminTransactionController::class, 'viewCart'])->name('cart');
    Route::post('/cart/add', [AdminTransactionController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/{id}', [AdminTransactionController::class, 'removeItem'])->name('cart.remove');
    Route::patch('/cart/{id}/update', [AdminTransactionController::class, 'updateQuantity'])->name('cart.update');
    Route::post('/cart/checkout', [AdminTransactionController::class, 'checkout'])->name('cart.checkout');

        // Draft
    Route::post('/cart/save-draft', [AdminTransactionController::class, 'saveDraft'])->name('cart.saveDraft');
    Route::get('/drafts', [AdminTransactionController::class, 'drafts'])->name('drafts');
    Route::post('/cart/load-draft/{id}', [AdminTransactionController::class, 'loadDraft'])->name('cart.loadDraft');

        // Invoice & History
    Route::get('/transaction-success/{transaction}', [AdminTransactionController::class, 'success'])->name('transactions.success');
    Route::resource('transactions', AdminTransactionController::class)->only(['index', 'show']);
    Route::post('/transactions/{transaction}/refund', [AdminTransactionController::class, 'refund'])->name('transactions.refund');
});


// ====================== Cashier Routes ======================
Route::middleware(['auth', 'role:cashier'])->prefix('cashier')->name('cashier.')->group(function () {

    // Dashboard
    Route::get('/dashboard', fn() => view('cashier.dashboard'))->name('dashboard');

    // Products
    Route::get('/products-list', [CashierTransactionController::class, 'showProducts'])->name('products.list');
    Route::resource('products', CashierProductController::class);

    // Transactions
    Route::get('/cart', [CashierTransactionController::class, 'viewCart'])->name('cart.index');
    Route::post('/cart/add', [CashierTransactionController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/{id}', [CashierTransactionController::class, 'removeItem'])->name('cart.remove');
    Route::patch('/cart/{id}/update', [CashierTransactionController::class, 'updateQuantity'])->name('cart.update');
    Route::post('/cart/checkout', [CashierTransactionController::class, 'checkout'])->name('cart.checkout');

    // Draft
    Route::post('/cart/save-draft', [CashierTransactionController::class, 'saveDraft'])->name('cart.saveDraft');
    Route::get('/transactions/drafts', [CashierTransactionController::class, 'drafts'])->name('transactions.drafts');
    Route::post('/cart/load-draft/{id}', [CashierTransactionController::class, 'loadDraft'])->name('cart.loadDraft');
    Route::get('/cart/draft', [CashierTransactionController::class, 'drafts'])->name('cart.draft');

    // Invoice & History
    Route::get('/transaction-success/{transaction}', [CashierTransactionController::class, 'success'])->name('transactions.success');
    Route::resource('transactions', CashierTransactionController::class)->only(['index', 'show']);
    Route::post('/transactions/{transaction}/refund', [CashierTransactionController::class, 'refund'])->name('transactions.refund');

});
