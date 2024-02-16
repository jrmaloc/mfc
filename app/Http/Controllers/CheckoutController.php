<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Registration;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function initiateCheckout(Request $request)
    {
        $activity = Activity::find($request->id);
        $user = User::where('name', $request->name)->first();
        $reg_fee = $request->reg_fee;

        $prefix = 'payment_';
        $requestReferenceNumber = uniqid($prefix);

        if ($user) {
            $existingRegistration = Registration::where('activity_id', $request->id)
                ->where('user_id', $user->id)
                ->first();

            if ($existingRegistration) {
                return back()->with('error', 'User is already registered for this activity');
            } else {
                $client = new Client();

                try {
                    $response = $client->request('POST', 'https://pg-sandbox.paymaya.com/checkout/v1/checkouts', [
                        'json' => [
                            'totalAmount' => [
                                'value' => 1,
                                'currency' => 'PHP',
                            ],
                            'redirectURL' => [
                                'success' => route('checkout.success'),
                                'failure' => route('checkout.failure'),
                                'cancel' => route('checkout.cancel'),
                            ],
                            'requestReferenceNumber' => $requestReferenceNumber,
                        ],
                        'headers' => [
                            'accept' => 'application/json',
                            'authorization' => 'Basic cGstWjBPU3pMdkljT0kyVUl2RGhkVEdWVmZSU1NlaUdTdG5jZXF3VUU3bjBBaDpzay1YOHFvbFlqeTYya0l6RWJyMFFSSzFoNGI0S0RWSGFOY3dNWWszOWpJblNs',
                            'content-type' => 'application/json',
                        ],
                    ]);

                    $responseData = json_decode($response->getBody()->getContents(), true);

                    $checkoutId = $responseData['checkoutId'];

                    if (isset($responseData['redirectUrl'])) {
                        $redirectURL = $responseData['redirectUrl'];
                        // Process $redirectURL as needed
                        return redirect($redirectURL);
                    } else {
                        // Handle the case where redirectURL is not present in the response
                    }
                } catch (\Exception $e) {
                    // Handle exceptions here
                    return $e->getMessage();
                }
            }
        }
    }

    public function checkoutSuccess(Request $request)
    {
        // $payload = $request->all();
        $client = new Client();

        try {
            $response = $client->request('GET', 'https://pg.paymaya.com/payments/v1/webhooks/93bab374-34f4-4a0f-b49b-e8824fd67001', [
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'Basic c2stdDRsMFVKZlJlbVg0MFZFWUU0TnZQMEtNTEcwd2JBd2tZa1FoaElTeEpseDpway00NzZUeHowbGttaVB5UDFtZ0MzR3NzN0pqQzF0SXlaNjFYbHVvb292MEVH',
                ],
            ]);

            $webhookData = json_decode($response->getBody(), true);

            if($webhookData){
                return redirect()->to($webhookData->callbackUrl);
            }

            // Process $webhookData as needed
            // For example, you can return it to a view or perform further operations
            return response()->json($webhookData);
        } catch (\Exception $e) {
            // Handle exceptions
            // For example, log the error message or return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }

        // return response()->json(['message' => 'Webhook received successfully', $payload]);
        // Handle successful checkout
    }

    public function checkoutFailure(Request $request)
    {
        $payload = $request->all();

        // return response()->json(['message' => 'Webhook received successfully', $payload]);
        // Handle failed checkout
        return view('payments.failed');
    }

    public function checkoutCancel(Request $request)
    {
        $payload = $request->all();

        // return response()->json(['message' => 'Webhook received successfully', $payload]);
        // Handle cancelled checkout
        return view('payments.cancelled');
    }
}
