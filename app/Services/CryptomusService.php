<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class CryptomusService
{
    protected $apiKey;

    protected $merchantId;

    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('payment.cryptomus.api_key');
        $this->merchantId = config('payment.cryptomus.merchant_id');
        $this->baseUrl = 'https://api.cryptomus.com/v1';
    }

    // Generate a payment link
    public function createPayment($amount, $details, $currency = 'USD')
    {
        $amount = number_format($amount, 2, '.', '');
        $data = [
            'amount' => $amount,
            'currency' => $currency,
            'order_id' => $details['reference'],
            'url_success' => route('cryptomus.success'),
            'url_callback' => route('cryptomus.success'),
            'url_return' => route('checkout'),
            'description' => $details['description'],
            'subtract' => 10,
            'accuracy_payment_percent' => 4,
            'currencies' => [
                [
                    'currency' => 'USDT',
                ],
                [
                    'currency' => 'BTC',
                ],
                [
                    'currency' => 'ETH',
                ],
                [
                    'currency' => 'SOL',
                ],
                [
                    'currency' => 'TON',
                ],
                [
                    'currency' => 'BNB',
                ],
                [
                    'currency' => 'TRX',
                ],
            ],

        ];
        $signature = $this->generateSignature($data);
        $response = Http::withHeaders([
            'merchant' => $this->merchantId,
            'sign' => $signature,
        ])->post("{$this->baseUrl}/payment", $data);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception("Cryptomus Error: {$response->body()}");
    }

    // Check the status of a payment
    public function getPaymentStatus($orderId)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get("{$this->baseUrl}/payment/{$orderId}");

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Unable to retrieve payment status.');
    }

    /**
     * Generate signature for API requests
     */
    private function generateSignature(array $payload): string
    {
        $jsonData = json_encode($payload, JSON_UNESCAPED_UNICODE);

        return md5(base64_encode($jsonData) . $this->apiKey);
    }

    /**
     * Validate webhook signature
     */
    public function validateSignature(array $payload, string $signature): bool
    {
        $calculatedSignature = $this->generateSignature($payload);

        return hash_equals($calculatedSignature, $signature);
    }
}
