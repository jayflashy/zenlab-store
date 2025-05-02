<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayPalService
{
    private readonly string $clientId;

    private readonly string $secret;

    private readonly string $baseUrl;

    private ?string $cachedAccessToken = null;

    private ?int $tokenExpiryTime = null;

    public function __construct()
    {
        $this->clientId = config('payment.paypal.client_id');
        $this->secret = config('payment.paypal.secret');
        $this->baseUrl = config('payment.paypal.mode') === 'sandbox'
            ? 'https://api-m.sandbox.paypal.com'
            : 'https://api.paypal.com';
    }

    /**
     * Get PayPal OAuth access token
     *
     * @throws Exception
     */
    private function getAccessToken(): string
    {
        // Return cached token if it's still valid
        if ($this->cachedAccessToken && $this->tokenExpiryTime > time()) {
            return $this->cachedAccessToken;
        }

        try {
            $response = Http::withBasicAuth($this->clientId, $this->secret)
                ->asForm()
                ->post("{$this->baseUrl}/v1/oauth2/token", [
                    'grant_type' => 'client_credentials',
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->cachedAccessToken = $data['access_token'];
                $this->tokenExpiryTime = time() + ($data['expires_in'] - 60); // Buffer of 60 seconds

                return $this->cachedAccessToken;
            }

            throw new Exception("PayPal API Error: {$response->body()}");
        } catch (Exception $exception) {
            Log::error('PayPal getAccessToken failed', [
                'error' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw new Exception('Failed to retrieve PayPal access token: ' . $exception->getMessage());
        }
    }

    /**
     * Create a PayPal payment order
     *
     * @throws Exception
     */
    public function createPayment(float $amount, array $details, string $currency = 'USD'): array
    {
        try {
            $accessToken = $this->getAccessToken();

            $formattedAmount = number_format($amount, 2, '.', '');

            $payload = [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => $currency,
                            'value' => $formattedAmount,
                            'breakdown' => [
                                'item_total' => [
                                    'currency_code' => $currency,
                                    'value' => $formattedAmount,
                                ],
                            ],
                        ],
                        'description' => $details['description'] ?? '',
                        'custom_id' => $details['reference'] ?? '',
                    ],
                ],
                'application_context' => [
                    'return_url' => route('paypal.success'),
                    'cancel_url' => route('checkout'),
                    'brand_name' => get_setting('title') ?? 'ZenLab',
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'PAY_NOW',
                ],
            ];

            $response = Http::withToken($accessToken)
                ->post("{$this->baseUrl}/v2/checkout/orders", $payload);

            if ($response->successful()) {
                return $response->json();
            }

            throw new Exception("PayPal API Error: {$response->body()}");
        } catch (Exception $exception) {

            throw new Exception("Failed to create PayPal payment: {$exception->getMessage()}");
        }
    }

    /**
     * Get order details
     *
     * @throws Exception
     */
    public function getOrderDetails(string $orderId): array
    {
        try {
            $accessToken = $this->getAccessToken();

            $response = Http::withToken($accessToken)
                ->get("{$this->baseUrl}/v2/checkout/orders/{$orderId}");

            if ($response->successful()) {
                return $response->json();
            }

            throw new Exception("PayPal API Error: {$response->body()}");
        } catch (Exception $exception) {
            Log::error('PayPal getOrderDetails failed', [
                'error' => $exception->getMessage(),
                'orderId' => $orderId,
                'trace' => $exception->getTraceAsString(),
            ]);
            throw new Exception("Failed to get PayPal order details : {$exception->getMessage()}");
        }
    }
}
