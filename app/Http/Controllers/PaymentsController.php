<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Session;

class PaymentsController extends Controller
{
    public function pay()
    {
        $data = [
            'data' => [
                'attributes' => [
                    'line_items' => [
                        [
                            'currency' => 'PHP',
                            'amount' => 10000,
                            'description' => 'Tithe',
                            'name' => 'Contribution',
                            'quantity' => 1
                        ]
                    ],
                    'payment_method_types' => [
                        'card',
                        'gcash',
                        'paymaya'
                    ],
                    'success_url' => 'http://127.0.0.1:8000/tithes/create',
                    'cancel_url' => 'http://127.0.0.1:8000/tithes/create',
                    'description' => 'Tithe'
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode(env('PAYMONGO_SECRET_KEY') . ':'),
            'accept' => 'application/json'
        ])
            ->post('https://api.paymongo.com/v1/checkout_sessions', $data);

        if ($response->successful()) {
            $decodedResponse = $response->json();
            if (isset($decodedResponse['data'])) {
                Session::put('session_id', $decodedResponse['data']['id']);
                return redirect()->to($decodedResponse['data']['attributes']['checkout_url']);
            }
        }

        dd($response->body());
    }



    public function success()
    {
        $sessionId = Session::get('session_id');
    }
}
