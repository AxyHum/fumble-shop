<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stripe\Checkout\Session;
use \Stripe\Stripe;

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

Route::get('/', function () {
    return view('home');
});

Route::get('/product/{product}/checkout', [ProductController::class, 'checkout']);
Route::get('/payments/verify/{channel}', [PaymentController::class, 'paymentVerify']);
Route::get('/payments/status/', [PaymentController::class, 'payStatus']);
Route::get('/order/invoice', [OrderController::class, 'invoice']);
Route::get('/orders/list', [OrderController::class, 'list']);
