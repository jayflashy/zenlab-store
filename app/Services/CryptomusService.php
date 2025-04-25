<?php

namespace App\Services;

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
        $data = [
            'amount' => $amount,
            'currency' => $currency,
            'order_id' => $details['reference'],
            'url_success' => route('cryptomus.success'),
            'url_callback' => route('cryptomus.success'),
            'url_return' => $details['cancelUrl'],
            'description' => $details['description'],
        ];
        $signature = $this->generateSignature($data);
        $response = Http::withHeaders([
            'merchant' => $this->merchantId,
            'sign' => $signature,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/payment", $data);

        return $response->json();
    }

    // Check the status of a payment
    public function getPaymentStatus($orderId)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->apiKey,
        ])->get("{$this->baseUrl}/payment/{$orderId}");

        if ($response->successful()) {
            return $response->json();
        }
        throw new \Exception('Unable to retrieve payment status.');
    }

    /**
     * Generate signature for API requests
     */
    private function generateSignature(array $payload): string
    {
        // ksort($payload);
        $jsonData = json_encode($payload, JSON_UNESCAPED_UNICODE);

        return $sign = md5(base64_encode($jsonData).$this->apiKey);
        // return hash_hmac('sha512', $jsonData, $this->apiKey);
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
