<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaystackService
{
    protected $publicKey;

    protected $secretKey;

    protected $baseUrl;

    public function __construct()
    {
        $this->publicKey = config('payment.paystack.public');
        $this->secretKey = config('payment.paystack.secret');
        $this->baseUrl = 'https://api.paystack.co';
    }

    // Generate a payment link
    public function createPayment($amount, $details, $currency = 'NGN')
    {
        $amount = round($amount);
        $data = [
            'email' => $details['email'],
            'amount' => $amount * 100,
            'currency' => $currency,
            'reference' => $details['reference'],
            'callback_url' => route('paystack.success'),
            'metadata' => $details,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/transaction/initialize", $data);

        return $response->json();
    }

    // Check the status of a payment
    public function getTransactionStatus($reference)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->secretKey,
        ])->get("{$this->baseUrl}/transaction/verify/{$reference}");

        return $response->json();
    }

    /**
     * Validate webhook signature
     */
    public function validateWebhookHash(array $payload): bool
    {
        $receivedHash = request()->header('x-paystack-signature');

        if (! $receivedHash || ($receivedHash !== hash_hmac('sha512', json_encode($payload), (string) $this->secretKey))) {
            // This request isn't from Paystack; discard
            return false;
        }

        return true;
    }
}
