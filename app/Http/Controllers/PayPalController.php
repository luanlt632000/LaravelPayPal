<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('paypal');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function payment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $order = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.success'),
                "cancel_url" => route('paypal.payment/cancel'),
            ],
            "purchase_units" => [
                0 => [
                    'amount' => [
                        'currency_code' => 'EUR',
                        'value' => '5',
                        "breakdown" => [
                            "item_total" => [
                                "currency_code" => "EUR", "value" => "5",
                            ],
                            "shipping" => [
                                "currency_code" => "EUR", "value" => "0",
                            ],
                            "tax_total" => [
                                "currency_code" => "EUR", "value" => "0",
                            ],
                            "discount" => [
                                "currency_code" => "EUR", "value" => "0",
                            ],
                        ],
                    ],
                    'items' => [
                        [
                            'name' => 'photo',
                            'sku' => 'photo001',
                            'quantity' => '3',
                            'unit_amount' => [
                                'currency_code' => 'EUR',
                                'value' => '1.00',
                            ],
                        ],
                        [
                            'name' => 'oto',
                            'sku' => 'oto001',
                            'quantity' => '2',
                            'unit_amount' => [
                                'currency_code' => 'EUR',
                                'value' => '1.00',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        dd($order);
        if (isset($order['id']) && null != $order['id']) {

            foreach ($order['links'] as $links) {
                if ('approve' == $links['rel']) {
                    return redirect()->away($links['href']);
                }
            }

            return redirect(route('cancel.payment'))->with('error', 'Something went wrong.');

        } else {
            return response([
                $order['message'] ?? 'Something went wrong.',
            ]);
            return redirect(route('create.payment'))
                ->with('error', $order['message'] ?? 'Something went wrong.');
        }

    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function paymentCancel()
    {
        return redirect(route('paypal'))
            ->with('error', 'You have canceled the transaction.');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && 'COMPLETED' == $response['status']) {
            return redirect(route('paypal'))->with('success', 'Transaction complete.');
        } else {
            return redirect(route('paypal'))
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
}
