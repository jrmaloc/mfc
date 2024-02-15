<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Parse and process the webhook payload
        $payload = $request->all();

        // Return a response (optional)
        return response()->json(['message' => 'Webhook received successfully', $payload]);
    }
}
