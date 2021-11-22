<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CustomerController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function(){
    return view('login');
});

Route::get('/logout', [UserController::class, 'logout']);
Route::get('/register', function(){
    return view('register');
});
Route::post('/register', [UserController::class, 'register'])->name('register-submit');

Route::post('/login', [UserController::class, 'login'])->name('login-submit');
Route::get('/products', [ProductController::class, 'index']);
Route::get('/detail/{id}', [ProductController::class, 'detail']);
Route::get('/search', [ProductController::class, 'search']);
Route::get('/cart/{id}', [ProductController::class, 'addToCart']);
Route::get('/cart', [ProductController::class, 'cart']);

Route::get('/cart-quantity', [ProductController::class, 'cartQuantityUpdated']);

Route::get('/cart-price', [ProductController::class, 'cartPriceDetail']);
Route::get('/cart-order', [ProductController::class, 'cartRemoveFromOrderList']);
Route::get('/cart-count', [ProductController::class, 'cartCount']);

Route::get('/order', [MenuController::class, 'menu']);
Route::get('/order-choices', [ProductController::class, 'orderChoices']);
Route::get('/order-added', [ProductController::class, 'orderAdded']);
Route::get('/order/{serialNumber}', [ProductController::class, 'editWithSerialNumber']);
Route::get('/order-edit', [ProductController::class, 'orderEdit']);
Route::get('/order-updated', [ProductController::class, 'orderUpdated']);

Route::get('/customer/add', [CustomerController::class, 'customerAdd']);
Route::post('/customer/add', [CustomerController::class, 'createCustomer'])->name('customer-submit');
Route::get('/customer/list', function(){
    return view('mycustomers');
});
Route::get('/customers-list', [CustomerController::class, 'listCustomers']);
Route::get('/customer/delete/{id}', [CustomerController::class, 'customerDelete']);
Route::get('/customer/edit/{id}', [CustomerController::class, 'customerEdit']);