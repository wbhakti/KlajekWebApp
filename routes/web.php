<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'App\Http\Controllers\HomeController@Index')->name('Index');
Route::get('/logout', 'App\Http\Controllers\AdminController@logout')->name('logout');
Route::get('/dashboard', 'App\Http\Controllers\AdminController@dashboard')->name('dashboard');
Route::get('/dashboard/mastermerchant', 'App\Http\Controllers\AdminController@MasterMerchant')->name('MasterMerchant');
Route::get('/dashboard/mastermenu', 'App\Http\Controllers\AdminController@MasterMenu')->name('MasterMenu');
Route::get('/dashboard/masterkategori', 'App\Http\Controllers\AdminController@MasterKategori')->name('MasterKategori');

Route::get('/restoran/{id}', 'App\Http\Controllers\HomeController@menu')->name('menu');

Route::post('/cart/add', 'App\Http\Controllers\CartController@addToCart')->name('cart.add');
Route::get('/cart', 'App\Http\Controllers\CartController@viewCart')->name('cart.view');
Route::delete('/cart/{id}', 'App\Http\Controllers\CartController@remove')->name('cart.remove');
Route::post('/update-cart/{id}', 'App\Http\Controllers\CartController@update')->name('cart.update');
Route::get('/checkout', 'App\Http\Controllers\CartController@checkout')->name('checkout');

Route::get('/petunjuk', 'App\Http\Controllers\HomeController@petunjuk')->name('petunjuk');
Route::get('/contact', 'App\Http\Controllers\HomeController@contact')->name('contact');
Route::get('/mitra', 'App\Http\Controllers\HomeController@mitra')->name('mitra');

