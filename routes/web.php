<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;

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

Route::get('/login', [UserController::class, 'login'])->name('auth.login');
Route::get('/register', [UserController::class, 'register'])->name('auth.register');
Route::post('/login', [UserController::class, 'signin'])->name('login-submit');
Route::get('/logout', [UserController::class, 'logout']);
Route::post('/register/submit', [UserController::class, 'signup'])->name('register.submit');

Route::get('/products', [ProductController::class, 'index']);
Route::get('/detail/{id}', [ProductController::class, 'detail']);
Route::get('/search', [ProductController::class, 'search']);
Route::get('/cart/{id}', [ProductController::class, 'addToCart']);
Route::get('/cart', [ProductController::class, 'cart']);

Route::get('/cart-quantity', [ProductController::class, 'cartQuantityUpdated']);

Route::get('/cart-price', [ProductController::class, 'cartPriceDetail']);
Route::get('/cart-order', [ProductController::class, 'cartRemoveFromOrderList']);
Route::get('/cart-count', [ProductController::class, 'cartCount']);
Route::get('/cart-note', [ProductController::class, 'cartNote']);
Route::get('/empty-cart', [ProductController::class, 'emptyCart']);

Route::get('/menu', [MenuController::class, 'menu']);
Route::get('/order-choices', [MenuController::class, 'orderChoices']);
Route::get('/order-added', [ProductController::class, 'orderAdded']);
Route::get('/order/{serialNumber}', [ProductController::class, 'editWithSerialNumber']);
Route::get('/order-edit', [ProductController::class, 'orderEdit']);
Route::get('/order-updated', [ProductController::class, 'orderUpdated']);

Route::get('/checkout', function(){
    return view('checkout');
});
Route::post('/checkout', [OrderController::class, 'checkout'])->name('place-order-submit');

Route::get('/customerRegister', [CustomerController::class, 'customerRegister'])->name('customer-signup');
Route::post('/customerSignup', [CustomerController::class, 'customerSignup'])->name('customer-signup-submit');
Route::get('/customerLogin', [CustomerController::class, 'customerLogin'])->name('customer-login');
Route::post('/customerLogin', [CustomerController::class, 'customerSignIn'])->name('customer-login-submit');
Route::get('/customerLogout', [CustomerController::class, 'customerLogout']);

Route::get('/customerLoginFromCheckout', [CustomerController::class, 'customerLoginFromCheckout']);


Route::get('orders-list', [OrderController::class, 'listOrders']);
Route::get('/order/delete/{id}', [OrderController::class, 'orderDelete']);
Route::get('/order/edit/{id}', [OrderController::class, 'orderEdit']);

Route::get('/users-list', [UserController::class, 'listusers']);
Route::get('/user-delete', [UserController::class, 'userDelete']);
Route::get('/user-edit', [UserController::class, 'userEdit']);

Route::get('/restricted', function(){
    return view('restricted');
});

Route::group(['middleware' => 'isEmployee'], function () {
    Route::get('/order', function(){
        return view('myorders');
    });
});

Route::group(['middleware' => 'isManager'], function () {
    Route::get('/order', function(){
        return view('myorders');
    });
    Route::get('/customer/list', [CustomerController::class, 'customerList'])->name('customer-list');
    Route::get('/customer/add', [CustomerController::class, 'customerAdd'])->name('customer-add');
    Route::post('/customer/add', [CustomerController::class, 'createCustomer'])->name('customer-submit');
    Route::get('/customers-list', [CustomerController::class, 'listCustomers']);
    Route::get('/customer/delete/{id}', [CustomerController::class, 'customerDelete']);
    Route::get('/customer/edit/{id}', [CustomerController::class, 'customerEdit']);
});

Route::group(['middleware' => 'isOwner'], function () {
    Route::get('/order', function(){
        return view('myorders');
    });
    Route::get('/customer/list', [CustomerController::class, 'customerList'])->name('customer-list');
    Route::get('/customer/add', [CustomerController::class, 'customerAdd'])->name('customer-add');
    Route::post('/customer/add', [CustomerController::class, 'createCustomer'])->name('customer-submit');
    Route::get('/customers-list', [CustomerController::class, 'listCustomers']);
    Route::get('/customer/delete/{id}', [CustomerController::class, 'customerDelete']);
    Route::get('/customer/edit/{id}', [CustomerController::class, 'customerEdit']);
});

Route::group(['middleware' => 'isAdmin'], function () {
    Route::get('/order', function(){
        return view('myorders');
    });
    Route::get('/customer/list', [CustomerController::class, 'customerList'])->name('customer-list');
    Route::get('/customer/add', [CustomerController::class, 'customerAdd'])->name('customer-add');
    Route::post('/customer/add', [CustomerController::class, 'createCustomer'])->name('customer-submit');
    Route::get('/user/list', [UserController::class, 'loadUsers']);
    Route::get('/customers-list', [CustomerController::class, 'listCustomers']);
    Route::get('/customer/delete/{id}', [CustomerController::class, 'customerDelete']);
    Route::get('/customer/edit/{id}', [CustomerController::class, 'customerEdit']);
});




