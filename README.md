# Sample project combining Paypal, reCaptcha, Excel export, laravel/breeze

## Pay with Paypal

#### [srmklive/paypal package](https://srmklive.github.io/laravel-paypal/docs.html)
- Install: `composer require srmklive/paypal`
- Structure of order data:
```js
[
    "intent" => "CAPTURE",
    "application_context" => [
        "return_url" => route('paypal.payment.success'),
        "cancel_url" => route('paypal.payment/cancel'),
    ],
    "purchase_units" => [
        0 => [
            'amount' => [
                'currency_code' => "",
                'value' => "",
                "breakdown" => [
                    "item_total" => [
                        "currency_code" => "",
                        "value" => "",
                    ],
                    "shipping" => [
                        "currency_code" => "",
                        "value" => "",
                    ],
                    "tax_total" => [
                        "currency_code" => "",
                        "value" => "",
                    ],
                    "discount" => [
                        "currency_code" => "",
                        "value" => "",
                    ],
                ],
            ],
            'items' => []
        ],
    ],
]
```
- Structure of items data:
```javascript
[
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
    
    ...
]
```
## reCaptcha

#### [anhskohbo/no-captcha package](https://github.com/anhskohbo/no-captcha)
- Install: `composer require anhskohbo/no-captcha`
- Register a new site (create reCaptcha): https://www.google.com/recaptcha/admin/create

## Excel export

#### [maatwebsite/excel package](https://docs.laravel-excel.com/3.1/exports/)
- Install: `composer require maatwebsite/excel -W --ignore-platform-req=ext-zip`
- Configuration: https://techsolutionstuff.com/post/laravel-10-import-export-csv-and-excel-file

## Starter kits

#### [laravel/breeze package](https://laravel.com/docs/10.x/starter-kits)
- Install: `composer require laravel/breeze`
