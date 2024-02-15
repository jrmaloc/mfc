<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymayaWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Verify webhook signature to ensure it's from PayMaya

        // Retrieve and process webhook payload
        $payload = $request->all();
        dd($payload);

        // Handle different webhook events
        switch ($payload['event']) {
            case 'payment.success':
                // Handle successful payment event
                break;
            case 'payment.failure':
                // Handle failed payment event
                break;
            // Add more cases for other events as needed
            default:
                // Handle unknown event
                break;
        }

        // Return a response to acknowledge receipt of the webhook
        return response()->json(['message' => 'Webhook received'], 200);
    }
}
