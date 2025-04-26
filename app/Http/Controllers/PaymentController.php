<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CryptomusService;
use App\Services\FlutterwaveService;
use App\Services\OrderService;
use App\Services\PayPalService;
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
    private $orderService;

    public function __construct(
        PaystackService $paystack,
        FlutterwaveService $flutterwave,
        PayPalService $paypal,
        CryptomusService $cryptomus,
        OrderService $orderService
    ) {
        $this->paystack = $paystack;
        $this->flutterwave = $flutterwave;
        $this->paypal = $paypal;
        $this->cryptomus = $cryptomus;
        $this->orderService = $orderService;
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

    public function initPaypal($data)
    {
        try {
            $res = $this->paypal->createPayment($data['amount'], $data);
            if (isset($res['status']) && $res['status'] === 'ERROR') {
                \Log::error('PayPal init failed', $res);

                return $this->errorResponse($res['message'] ?? 'Unable to initialize payment');
            }
            foreach ($res['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect($link['href']);
                }
            }
            throw new \Exception('Unable to initialize payment');
        } catch (\Exception $e) {
            throw new \Exception('Unable to initialize payment');
        }
    }

    public function initCryptomus($order) {}

    public function paystackSuccess(Request $request)
    {
        try {
            $paymentData = $this->paystack->getTransactionStatus($request->reference);
            // Verify transaction details
            if (! empty($paymentData['data']) && $paymentData['data']['status'] == 'success') {
                $details = $paymentData['data']['metadata'];
                $order = Order::where('code', $paymentData['data']['reference'])->firstOrFail();
                $this->orderService->completeOrder($order, $paymentData);

                return $this->callbackResponse('success', 'Payment was successful', route('payment.success', $order->code));
            } else {
                // Find order by reference
                $order = Order::where('code', $paymentData['data']['reference'])->firstOrFail();
                $this->orderService->failOrder($order, $paymentData);
                return $this->callbackResponse('error', 'Payment was not successful', route('checkout'));
            }
        } catch (\Exception $e) {
            logger()->error('Paystack callback error: ' . $e->getMessage());
            return redirect()->route('checkout')->with('error', 'Something went wrong with your payment');
        }
    }

    public function flutterSuccess(Request $request)
    {
        if ($request->status == 'cancelled') {
            return $this->errorResponse('Payment Was Cancelled');
        }
        $transactionID = request()->transaction_id;

        return $response = $this->flutterwave->getTransactionStatus($transactionID);
    }

    public function paypalSuccess(Request $request)
    {
        return $request;
    }

    public function callbackResponse($type, $message, $url = null)
    {
        if (request()->wantsJson()) {
            if ($type == 'success') {
                return $this->successResponse($message);
            }

            return $this->errorResponse($message);
        }
        if ($type == 'success') {
            return redirect($url)->withSuccess($message);
        }

        return redirect($url)->withError($message);
    }
}
