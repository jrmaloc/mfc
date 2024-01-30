<?php

namespace App\Services;

use GuzzleHttp\Client;

class PaymongoService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.paymongo.com/v1/checkout_sessions',
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic c2tfdGVzdF9XTDRKOUJObkZ0akdDejFIWGdXVnBLOUE6',
                'content-type' => 'application/json',
            ],
        ]);
    }

    public function createPaymentSource($amount, $redirectSuccess, $redirectFailed, $type = 'gcash', $currency = 'PHP')
    {
        $body = [
            'data' => [
                'attributes' => [
                    'amount' => $amount,
                    'redirect' => [
                        'success' => $redirectSuccess,
                        'failed' => $redirectFailed,
                    ],
                    'type' => $type,
                    'currency' => $currency,
                ],
            ],
        ];

        $response = $this->client->post('sources', [
            'json' => $body,
        ]);

        return json_decode($response->getBody(), true);
    }

}
