<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{

    private $items = [
        [
            'id' => 1,
            'item' => [
                'name' => 'Laptop',
                'sku' => 'L001',
                'quantity' => '1',
                'unit_amount' => [
                    'currency_code' => 'USD',
                    'value' => '1000',
                ],
            ]
        ],
        [
            'id' => 2,
            'item' => [
                'name' => 'iPad',
                'sku' => 'I001',
                'quantity' => '1',
                'unit_amount' => [
                    'currency_code' => 'USD',
                    'value' => '500',
                ],
            ]
        ],
        [
            'id' => 3,
            'item' => [
                'name' => 'Dep Laos',
                'sku' => 'D001',
                'quantity' => '1',
                'unit_amount' => [
                    'currency_code' => 'USD',
                    'value' => '100',
                ],
            ]
        ],
    ];

    private $paymentCurrency = 'USD';


    /**
     * Write code on Method
     *
     */
    public function index(Request $request)
    {
        $orders = Payment::all();
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        foreach( $orders as $order ){
            $order['data'] = json_encode($provider->showOrderDetails($order['id_order']));
        }
        return view('paypal', ['user' => $request->user(), 'orders' => $orders ?? []]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function payment(Request $request)
    {
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $item = collect($this->items)->filter(function ($item) use ($id) {
            return $item['id'] == $id;
        })->first();

        $totalAmount = $item['item']['unit_amount']['value'] * $item['item']['quantity'];
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
                        'currency_code' => $this->paymentCurrency,
                        'value' => $totalAmount,
                        "breakdown" => [
                            "item_total" => [
                                "currency_code" => $this->paymentCurrency,
                                "value" => $totalAmount,
                            ],
                            "shipping" => [
                                "currency_code" => $this->paymentCurrency,
                                "value" => "0",
                            ],
                            "tax_total" => [
                                "currency_code" => $this->paymentCurrency,
                                "value" => "0",
                            ],
                            "discount" => [
                                "currency_code" => $this->paymentCurrency,
                                "value" => "0",
                            ],
                        ],
                    ],
                    //items
                    'items' => [$item['item']]
                ],
            ],
        ]);

        // dd($order);
        if (isset($order['id']) && null != $order['id']) {

            foreach ($order['links'] as $links) {
                if ('approve' == $links['rel']) {
                    Payment::create(['user_id' => $user_id, 'id_order' => $order['id'], 'status' => 'pending']);
                    return redirect()->away($links['href']);
                }
            }

            return response()->redirectTo(route('paypal.payment/cancel', ["error" => 'Something went wrong.']));

        } else {
            return response()->redirectTo(route('paypal.payment/cancel', ["error" => $order['error']['message'] ?? 'Something went wrong.']));
        }

    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function paymentCancel(Request $request)
    {
        $token = $request->input('token');
        $order = Payment::where('id_order', $token)->first();
        $order['status'] = 'cancel';
        $order->save();

        $error = $request->input("error");
        return redirect(route('paypal'))->with('error', $error ?? 'You have canceled the transaction.');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function paymentSuccess(Request $request)
    {
        $token = $request->input('token');

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($token);


        $order = Payment::where('id_order', $token)->first();
        $order['status'] = 'success';
        $order->save();

        if (isset($response['status']) && 'COMPLETED' == $response['status']) {
            return redirect(route('paypal'))->with('success', 'Transaction complete.');
        } else {
            return redirect(route('paypal'))
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }
}
