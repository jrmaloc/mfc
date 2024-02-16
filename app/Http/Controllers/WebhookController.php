<?php

namespace App\Http\Controllers;

use Aceraven777\PayMaya\API\Checkout;
use Aceraven777\PayMaya\PayMayaSDK;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        // // Parse and process the webhook payload
        // $payload = $request->all();

        // // Return a response (optional)
        // return response()->json(['message' => 'Webhook received successfully', $payload]);

        // return redirect(route('checkout.success'));

        PayMayaSDK::getInstance()->initCheckout(
            config('paymaya.public_key'),
            config('paymaya.secret_key'),
            (app()->environment('production') ? 'PRODUCTION' : 'SANDBOX')
        );

        $transaction_id = $request->get('id');
        if (!$transaction_id) {
            return ['status' => false, 'message' => 'Transaction Id Missing'];
        }

        $itemCheckout = new Checkout();
        $itemCheckout->id = $transaction_id;

        $checkout = $itemCheckout->retrieve();

        if ($checkout === false) {
            $error = $itemCheckout::getError();
            return redirect()->back()->withErrors(['message' => $error['message']]);
        }

        return response()->json(['success', $checkout]);
    }
}
