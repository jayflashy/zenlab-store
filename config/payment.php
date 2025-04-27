<?php

/*
 * Payment Gateways Configurations .
 */

return [

    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'secret' => env('PAYPAL_CLIENT_SECRET'),
        'mode' => env('PAYPAL_MODE', 'sandbox'), // or 'live'
    ],
    'flutterwave' => [
        'public' => env('FLUTTERWAVE_PUBLIC'),
        'secret' => env('FLUTTERWAVE_SECRET'),
        'hash' => env('FLUTTERWAVE_HASH'),
    ],
    'paystack' => [
        'public' => env('PAYSTACK_PUBLIC_KEY'),
        'secret' => env('PAYSTACK_SECRET_KEY'),
        'url' => env('PAYSTACK_PAYMENT_URL', 'https://api.paystack.co'),
    ],
    'cryptomus' => [
        'api_key' => env('CRYPTOMUS_API_KEY'),
        'merchant_id' => env('CRYPTOMUS_MERCHANT_ID'),
    ],
];
