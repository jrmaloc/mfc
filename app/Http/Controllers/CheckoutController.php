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
                    $response = $client->request('POST', 'https://pg.paymaya.com/checkout/v1/checkouts', [
                        'json' => [
                            'totalAmount' => [
                                'value' => 1,
                                'currency' => 'PHP',
                            ],
                            'redirectURL' => [
                                'success' => 'payment/success',
                                'failure' => 'payment/failed',
                                'cancel' => 'payment/cancelled',
                            ],
                            'requestReferenceNumber' => $requestReferenceNumber,
                        ],
                        'headers' => [
                            'accept' => 'application/json',
                            'authorization' => 'Basic cGstNDc2VHh6MGxrbWlQeVAxbWdDM0dzczdKakMxdEl5WjYxWGx1b29vdjBFRzpzay1zay10NGwwVUpmUmVtWDQwVkVZRTROdlAwS01MRzB3YkF3a1lrUWhoSVN4Smx4',
                            'content-type' => 'application/json',
                        ],
                    ]);

                    $responseData = json_decode($response->getBody()->getContents(), true);

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
        // Handle successful checkout
        return view('payments.success');
    }

    public function checkoutFailure(Request $request)
    {
        // Handle failed checkout
        return view('payments.failed');
    }

    public function checkoutCancel(Request $request)
    {
        // Handle cancelled checkout
        return view('payments.cancelled');
    }
}
