<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});


Route::middleware(['auth', 'admin'])->group(function () {

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products.variants', ProductVariantController::class);

    Route::get('admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::patch('admin/orders/{order}', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('/admin/low-stock', [AdminNotificationController::class, 'lowStockNotifications'])->name('admin.lowStock');

    Route::post('/products/bulk-upload', [ProductController::class, 'bulkUpload'])->name('products.bulk-upload');


});


Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register')->middleware('guest');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');



Route::middleware(['auth'])->group(function () {

    Route::get('/customer/products', [CustomerProductController::class, 'index'])->name('customer.products.index');


    Route::get('/cart', [CartController::class, 'index'])->name('customer.cart.index');
    Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{cartId}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartId}', [CartController::class, 'remove'])->name('cart.remove');


    Route::get('/checkout/shipping', [CheckoutController::class, 'shipping'])->name('customer.checkout.shipping');
    Route::post('/checkout/payment', [CheckoutController::class, 'payment'])->name('customer.checkout.payment');
    Route::post('/checkout/review', [CheckoutController::class, 'review'])->name('customer.checkout.review');
    Route::post('/checkout/complete', [CheckoutController::class, 'complete'])->name('customer.checkout.complete');


    Route::get('customer/orders', [CustomerController::class, 'orderHistory'])->name('customer.orders');
    Route::get('customer/orders/{id}', [CustomerController::class, 'showOrder'])->name('customer.orders.show');


    Route::get('customer/search', [SearchController::class, 'index'])->name('customer.search');
    Route::get('customer/filter', [SearchController::class, 'filter'])->name('customer.filter');
    Route::get('/sort', [SearchController::class, 'sort'])->name('customer.sort');

});

