<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FlutterwaveService
{
    protected $publicKey;

    protected $secretKey;

    protected $hashKey;

    protected $baseUrl;

    public function __construct()
    {
        $this->publicKey = config('payment.flutterwave.public');
        $this->hashKey = config('payment.flutterwave.hash');
        $this->secretKey = config('payment.flutterwave.secret');
        $this->baseUrl = 'https://api.flutterwave.com/v3';
    }

    // Generate a payment link
    public function createPayment($amount, $details, $currency = 'NGN')
    {
        $amount = round($amount);
        $data = [
            'payment_options' => config('payment.flutterwave.payment_options', 'card,banktransfer,ussd,mobilemoneyghana'),
            'amount' => $amount,
            'email' => $details['email'],
            'tx_ref' => $details['reference'],
            'meta' => $details,
            'currency' => $currency,
            'redirect_url' => route('flutter.success'),
            'customer' => [
                'email' => $details['email'],
                'phonenumber' => $details['phone'] ?? '',
                'name' => $details['name'],
            ],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->secretKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/payments", $data);

        return $response->json();
    }

    // Check the status of a payment
    public function getTransactionStatus($reference)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->secretKey,
        ])->get("{$this->baseUrl}/transactions/{$reference}/verify");

        return $response->json();
    }

    /**
     * Validate webhook signature
     */
    public function validateWebhookHash(array $payload): bool
    {
        $receivedHash = request()->header('verif-hash');
        $hash = $this->hashKey;

        if (! $receivedHash || ($hash !== $receivedHash)) {
            // This request isn't from Flutterwave; discard
            return false;
        }

        return true;
    }
}
