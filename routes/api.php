<?php

use App\Exports\OrdersExport;
use App\Http\Controllers\PayPalController;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

 Route::get('/export', function(){
    return Excel::download(new OrdersExport, now().'_Orders.xlsx');
})->name('export');

