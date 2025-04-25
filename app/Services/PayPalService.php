<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayPalService
{
    private string $clientId;

    private string $secret;

    private string $baseUrl;

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
        } catch (Exception $e) {
            Log::error('PayPal getAccessToken failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw new Exception('Failed to retrieve PayPal access token: '.$e->getMessage());
        }
    }

    /**
     * Create a PayPal payment order
     *
     * @throws Exception
     */
    public function createPayment(float $amount, string $currency, array $details): array
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
                    'return_url' => $details['returnUrl'],
                    'cancel_url' => $details['cancelUrl'],
                    'brand_name' => get_setting('title'),
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'PAY_NOW',
                ],
            ];

            $response = Http::withToken($accessToken)
                ->post("{$this->baseUrl}/v2/checkout/orders", $payload);

            if ($response->successful()) {
                return $response->json();
            }

            $res = [
                'status' => 'ERROR',
                'message' => "PayPal API Error: {$response->body()}",
            ];

            return response()->json($res, 400);
            throw new Exception("PayPal API Error: {$response->body()}");
        } catch (Exception $e) {
            Log::error('PayPal createPayment failed', [
                'error' => $e->getMessage(),
                'amount' => $amount,
                'currency' => $currency,
                'details' => $details,
                'trace' => $e->getTraceAsString(),
            ]);
            $res = [
                'status' => 'ERROR',
                'message' => "PayPal API Error: {$response->body()}",
            ];

            throw new Exception('Failed to create PayPal payment: '.$e->getMessage());
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
            $res = [
                'status' => 'ERROR',
                'message' => "PayPal API Error: {$response->body()}",
            ];

            return response()->json($res, 400);

            throw new Exception("PayPal API Error: {$response->body()}");
        } catch (Exception $e) {
            Log::error('PayPal getOrderDetails failed', [
                'error' => $e->getMessage(),
                'orderId' => $orderId,
                'trace' => $e->getTraceAsString(),
            ]);
            $res = [
                'status' => 'ERROR',
                'message' => "PayPal API Error: {$response->body()}",
            ];

            return response()->json($res, 400);

            throw new Exception('Failed to get PayPal order details: '.$e->getMessage());
        }
    }
}
