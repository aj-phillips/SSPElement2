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

Route::post('/add_to_basket', [\App\Http\Controllers\MenuController::class, 'addToBasket'])->name('addToBasket');

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin');
});
