<?php

use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::group(['prefix' => 'paypal'], function () {
        Route::get('/', [PayPalController::class, 'index'])->name('paypal');
        Route::get('/payment', [PayPalController::class, 'payment'])->name('paypal.payment');
        Route::get('/payment/success', [PayPalController::class, 'paymentSuccess'])->name('paypal.payment.success');
        Route::get('/payment/cancel', [PayPalController::class, 'paymentCancel'])->name('paypal.payment/cancel');
    });
});

require __DIR__ . '/auth.php';
