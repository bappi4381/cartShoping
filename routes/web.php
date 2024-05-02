<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

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


Route::get('/', [BookController::class, 'index']);
Route::get('/shopping-cart', [BookController::class, 'bookCart'])->name('shopping.cart');
Route::get('/book/{id}', [BookController::class, 'addBooktoCart'])->name('addbook.to.cart');
Route::post('/cart/increment/{id}', [BookController::class, 'incrementCartItem'])->name('cart.increment');
Route::post('/cart/decrement/{id}', [BookController::class, 'decrementCartItem'])->name('cart.decrement');
Route::patch('/update-shopping-cart', [BookController::class, 'update'])->name('update-cart');
Route::delete('/delete-cart-product', [BookController::class, 'deleteProduct'])->name('delete.cart.product');