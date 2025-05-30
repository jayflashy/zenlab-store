<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CryptomusService;
use App\Services\FlutterwaveService;
use App\Services\OrderService;
use App\Services\PayPalService;
use App\Services\PaystackService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Log;

class PaymentController extends Controller
{
    use ApiResponse;

    public function __construct(private PaystackService $paystack, private FlutterwaveService $flutterwave, private PayPalService $paypal, private CryptomusService $cryptomus, private OrderService $orderService) {}

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

            throw new Exception('Unable to initialize payment');
        } catch (Exception) {
            throw new Exception('Unable to initialize payment');
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

            throw new Exception('Unable to initialize payment');
        } catch (Exception) {
            throw new Exception('Unable to initialize payment');
        }
    }

    public function initPaypal($data)
    {
        try {
            $res = $this->paypal->createPayment($data['amount'], $data);
            if (isset($res['status']) && $res['status'] === 'ERROR') {
                Log::error('PayPal init failed', $res);

                return $this->errorResponse($res['message'] ?? 'Unable to initialize payment');
            }

            foreach ($res['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect($link['href']);
                }
            }

            throw new Exception('Unable to initialize payment');
        } catch (Exception) {
            throw new Exception('Unable to initialize payment');
        }
    }

    public function initCryptomus($data)
    {
        try {
            $res = $this->cryptomus->createPayment($data['amount'], $data);
            if (isset($res['result']['url'])) {
                return redirect($res['result']['url']);
            }

            throw new Exception('Unable to initialize payment');
        } catch (Exception) {
            throw new Exception('Unable to initialize payment');
        }
    }

    public function paystackSuccess(Request $request)
    {
        try {
            $paymentData = $this->paystack->getTransactionStatus($request->reference);
            // Verify transaction details
            if (! empty($paymentData['data']) && $paymentData['data']['status'] == 'success') {
                $metadata = $paymentData['data']['metadata'];
                $order = Order::where('code', $paymentData['data']['reference'])->firstOrFail();
                $this->orderService->completeOrder($order, $paymentData);

                return $this->callbackResponse('success', 'Payment was successful', route('payment.success', $order->code));
            }

            // Find order by reference
            $order = Order::where('code', $paymentData['data']['reference'])->firstOrFail();
            $this->orderService->failOrder($order, $paymentData);

            return $this->callbackResponse('error', 'Payment was not successful', route('checkout'));
        } catch (Exception $exception) {
            logger()->error('Paystack callback error: ' . $exception->getMessage());

            return redirect()->route('checkout')->with('error', 'Something went wrong with your payment');
        }
    }

    public function flutterSuccess(Request $request)
    {
        if ($request->status == 'cancelled') {
            return $this->callbackResponse('error', 'Payment Was Cancelled', route('checkout'));
        }

        $transactionID = $request->transaction_id;
        $paymentData = $this->flutterwave->getTransactionStatus($transactionID);
        if ($paymentData['status'] == 'success' && $paymentData['data']['status'] == 'successful') {
            $metadata = $paymentData['data']['meta'];
            $order = Order::where('code', $paymentData['data']['tx_ref'])->firstOrFail();
            $this->orderService->completeOrder($order, $paymentData);

            return $this->callbackResponse('success', 'Payment was successful', route('payment.success', $order->code));
        }

        $order = Order::where('code', $paymentData['data']['tx_ref'])->firstOrFail();
        $this->orderService->failOrder($order, $paymentData);

        return $this->callbackResponse('error', 'Payment was not successful', route('checkout'));
    }

    public function paypalSuccess(Request $request)
    {
        $orderId = $request->token;
        if (empty($orderId)) {
            return $this->callbackResponse('error', 'Invalid Payment', route('checkout'));
        }

        $paymentData = $this->paypal->getOrderDetails($orderId);
        if ($paymentData['status'] == 'APPROVED') {
            // confirm payment
            $code = $paymentData['purchase_units'][0]['custom_id'] ?? null;
            $order = Order::where('code', $code)->firstOrFail();
            $this->orderService->completeOrder($order, $paymentData);

            return $this->callbackResponse('success', 'Payment was successful', route('payment.success', $order->code));
        }

        $order = Order::where('code', $paymentData['purchase_units'][0]['custom_id'])->firstOrFail();
        $this->orderService->failOrder($order, $paymentData);

        return $this->callbackResponse('error', 'Payment was not successful', route('checkout'));
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
