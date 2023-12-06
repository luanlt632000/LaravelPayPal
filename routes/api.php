<?php

use App\Http\Controllers\PayPalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('create-payment', [PayPalController::class, 'index'])->name('payment.create');
Route::get('invoices', function () {
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();

    $data = json_decode('{
        "name": "Video Streaming Service",
        "description": "Video streaming service",
        "type": "SERVICE",
        "category": "SOFTWARE",
        "image_url": "https://example.com/streaming.jpg",
        "home_url": "https://example.com/home"
        }', true);

    $product = $provider->setRequestHeader('PayPal-Request-Id', 'create-product-' . time())->createProduct($data);

    $inv = $provider->showOrderDetails('0KX38537YL610435R');
    // $invoice_no = $provider->generateInvoiceNumber();

    dd(
        $inv
    );
})->name('payment.invoices');
