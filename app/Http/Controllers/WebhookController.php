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
        $payload = $request->all();

        // // Return a response (optional)
        // return response()->json(['message' => 'Webhook received successfully', $payload]);

        // return redirect(route('checkout.success'));

        return view('payments.authorized');
    }
}
