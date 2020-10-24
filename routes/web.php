<?php

use Illuminate\Http\Request;
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
    return view('home');
});

Route::resource('orders', \App\Http\Controllers\OrdersController::class)->only(['index', 'show']);


Route::get('paymate', function (Request $request) {

    $order = \App\Models\Order::find($request->input('order_id'));
    return view('paymate.create')->withOrder($order);
})->name('paymate.create');
