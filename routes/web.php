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

Route::get('/cart', [OrderController::class, 'cart']);
Route::get('/cart-quantity', [OrderController::class, 'cartQuantityUpdated']);

Route::get('/cart-note', [OrderController::class, 'cartNote']);
Route::get('/empty-cart', [OrderController::class, 'emptyCart']);

Route::get('/menu', [MenuController::class, 'menu']);
Route::get('/order-choices', [MenuController::class, 'orderChoices']);
Route::get('/order-added', [OrderController::class, 'orderAdded']);
Route::get('/order-edit', [OrderController::class, 'orderEditForPopup']);
Route::get('/order-updated', [OrderController::class, 'orderUpdated']);

Route::get('/checkout', function(){
    return view('checkout');
});
Route::post('/checkout', [OrderController::class, 'checkout'])->name('place-order-submit');

Route::get('/customerRegister', [CustomerController::class, 'customerRegister'])->name('customer-signup');
Route::post('/customerSignup', [CustomerController::class, 'customerSignup'])->name('customer-signup-submit');
Route::get('/customerLogin', [CustomerController::class, 'customerLogin'])->name('customer-login');
Route::post('/customerLogin', [CustomerController::class, 'customerSignIn'])->name('customer-login-submit');
Route::get('/customerLogout', [CustomerController::class, 'customerLogout']);

Route::get('/restricted', function(){
    return view('restricted');
});

Route::get('/order', function(){
    return view('myorders');
})->middleware('isEmployee');   // This means employee, manager and admin can access

Route::group(['middleware' => 'isEmployee'], function () {  // This means employee, manager and admin can access
    Route::get('orders-list', [OrderController::class, 'listOrders']);
    Route::get('/order/delete/{id}', [OrderController::class, 'orderDelete']);
    Route::get('/order/edit/{id}', [OrderController::class, 'orderEdit']);
});

Route::group(['middleware' => 'isManager'], function () {   // This means manager and admin can access the following routes
    Route::get('/customer/list', [CustomerController::class, 'customerList'])->name('customer-list');
    Route::get('/customer/add', [CustomerController::class, 'customerAdd'])->name('customer-add');
    Route::post('/customer/add', [CustomerController::class, 'createUpdateCustomer'])->name('customer-submit');
    Route::get('/customers-list', [CustomerController::class, 'listCustomers']);
    Route::get('/customer/delete/{id}', [CustomerController::class, 'customerDelete']);
    Route::get('/customer/edit/{id}', [CustomerController::class, 'customerEdit']);
});

Route::group(['middleware' => 'isAdmin'], function () {
    Route::get('/user/list', [UserController::class, 'loadUsers']);
    Route::get('/users-list', [UserController::class, 'listusers']);
    Route::get('/user-delete', [UserController::class, 'userDelete']);
    Route::get('/user-edit', [UserController::class, 'userEdit']);
});


