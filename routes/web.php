<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnimalsController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect('menu');
});

Route::get('/menu', [\App\Http\Controllers\MenuController::class, 'index'])->name('menu');
Route::get('/orders', [\App\Http\Controllers\OrdersController::class, 'index'])->name('orders');
Route::get('/basket', [\App\Http\Controllers\BasketController::class, 'showBasket'])->name('basket');

Route::post('/basket/deal/add', [\App\Http\Controllers\BasketController::class, 'addDealToBasket'])->name('addDealToBasket');
Route::post('/basket/deal/clear', [\App\Http\Controllers\BasketController::class, 'clearDeals'])->name('clearDeals');
Route::post('/basket/add', [\App\Http\Controllers\BasketController::class, 'addToBasket'])->name('addToBasket');
Route::post('/basket/clear', [\App\Http\Controllers\BasketController::class, 'removeAllFromBasket'])->name('removeAllFromBasket');

Route::post('/orders/create', [\App\Http\Controllers\OrdersController::class, 'createOrder'])->name('createOrder');
Route::get('/orders/view/{order}', [\App\Http\Controllers\ViewOrderController::class, 'viewOrder'])->name('viewOrder');
Route::get('/orders/delete/{order}', [\App\Http\Controllers\OrdersController::class, 'deleteOrder'])->name('deleteOrder');
Route::get('/orders/deletelocal/{id}', [\App\Http\Controllers\OrdersController::class, 'deleteOrderFromSession'])->name('deleteOrderFromSession');

Auth::routes();