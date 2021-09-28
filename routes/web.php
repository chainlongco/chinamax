<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenuController;

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

Route::get('/cart-data', [ProductController::class, 'cartData']);

Route::get('/cart-price', [ProductController::class, 'cartPriceDetail']);
Route::get('/cart-order', [ProductController::class, 'cartRemoveFromOrderList']);
Route::get('/cart-count', [ProductController::class, 'cartCount']);

Route::get('/order', [MenuController::class, 'menu']);