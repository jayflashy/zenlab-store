<?php

namespace App\Http\Controllers;

use App\Services\FlutterwaveService;
use App\Services\PaystackService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use ApiResponse;

    private $paystack;

    private $paypal;

    private $flutterwave;

    private $cryptomus;

    public function __construct(
        PaystackService $paystack,
        FlutterwaveService $flutterwave,
    ) {
        $this->paystack = $paystack;
        $this->flutterwave = $flutterwave;
    }

    public function initPaystack($data)
    {
        try {
            // convert to ngn .
            if ($data['currency'] != 'NGN') {
                $data['amount'] = $data['ngn_amount'];
            }
            $res = $this->paystack->createPayment($data['amount'], $data);
            if (isset($res['data']['authorization_url'])) {

                return redirect($res['data']['authorization_url']);
            }
            throw new \Exception('Unable to initialize payment');
        } catch (\Exception $e) {
            throw new \Exception('Unable to initialize payment');
        }
    }

    public function initFlutter($data)
    {
        try {
            // convert to ngn .
            $amount = $data['amount'];
            if ($data['currency'] != 'NGN') {
                $amount = $data['ngn_amount'];
            }
            $res = $this->flutterwave->createPayment($amount, $data);
            if (isset($res['data']['link'])) {
                return redirect($res['data']['link']);
            }

            throw new \Exception('Unable to initialize payment');
        } catch (\Exception $e) {
            throw new \Exception('Unable to initialize payment');
        }
    }

    public function initPaypal($order) {}

    public function initCryptomus($order) {}

    public function paystackSuccess(Request $request)
    {
        return $payment = $this->paystack->getTransactionStatus($request->reference);
    }

    public function flutterSuccess(Request $request)
    {
        if ($request->status == 'cancelled') {
            return $this->errorResponse('Payment Was Cancelled');
        }
        $transactionID = request()->transaction_id;

        return $response = $this->flutterwave->getTransactionStatus($transactionID);
    }
}
