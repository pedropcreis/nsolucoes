<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\MercadoPagoController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/detail/{id}', [ProductController::class, 'detail'])->name('product.detail');

Route::any('/mercado-pago/webhooks', [MercadoPagoController::class, 'webhooks'])->name('mp.webhooks');
Route::any('/handle-payment', [MercadoPagoController::class, 'handlePayment'])->name('success.payment');

Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.cart')->middleware('auth');
Route::get('/cart', [CartController::class, 'index'])->name('cart')->middleware('auth');

Route::post('/store-sale', [SaleController::class, 'store'])->name('store.sale')->middleware('auth');

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users-ajax', [UserController::class, 'list'])->name('users.ajax');
    Route::get('/create-user', [UserController::class, 'create'])->name('create.user');
    Route::post('/store-user', [UserController::class, 'store'])->name('store.user');
    
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products-ajax', [ProductController::class, 'list'])->name('products.ajax');
    Route::get('/create-product', [ProductController::class, 'create'])->name('create.product');
    Route::post('/store-product', [ProductController::class, 'store'])->name('store.product');

    Route::get('/sales', [SaleController::class, 'index'])->name('sales');
    Route::get('/sales-ajax', [SaleController::class, 'list'])->name('sales.ajax');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard')->middleware('admin');
});
