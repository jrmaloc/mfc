<?php

namespace App\Http\Controllers;

use Aceraven777\PayMaya\API\Checkout;
use Aceraven777\PayMaya\API\Customization;
use Aceraven777\PayMaya\Model\Checkout\Item;
use Aceraven777\PayMaya\Model\Checkout\ItemAmount;
use Aceraven777\PayMaya\Model\Checkout\ItemAmountDetails;
use Aceraven777\PayMaya\PayMayaSDK;
use App\Http\Controllers\Controller;
use App\Libraries\PayMaya\User as PayMayaUser;
use App\Models\Activity;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function customizeMerchantPage(Request $request)
    {
        PayMayaSDK::getInstance()->initCheckout(
            config('paymaya.public_key'),
            config('paymaya.secret_key'),
            (app()->environment('production') ? 'PRODUCTION' : 'SANDBOX')
        );

        $shopCustomization = new Customization();
        $shopCustomization->get();

        $shopCustomization->logoUrl = asset('favicon-96x96.png');
        $shopCustomization->iconUrl = asset('favicon-32x32.png');
        $shopCustomization->appleTouchIconUrl = asset('apple-touch-icon.png');
        $shopCustomization->customTitle = 'PayMaya Payment Gateway';
        $shopCustomization->colorScheme = '#f3dc2a';

        $shopCustomization->set();

        return $shopCustomization;
    }

    public function initiateCheckout(Request $request)
    {
        $activity = Activity::find($request->id);
        $user = User::where('email', $request->email)->first();
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
                // User is not already registered for this activity
                // Initialize PayMaya SDK for checkout
                PayMayaSDK::getInstance()->initCheckout(
                    config('paymaya.public_key'),
                    config('paymaya.secret_key'),
                    app()->environment('production') ? 'PRODUCTION' : 'SANDBOX'
                );

                $shopCustomization = new Customization();
                $shopCustomization->get();

                $shopCustomization->logoUrl = asset('favicon-96x96.png');
                $shopCustomization->iconUrl = asset('favicon-32x32.png');
                $shopCustomization->appleTouchIconUrl = asset('apple-touch-icon.png');
                $shopCustomization->customTitle = 'PayMaya Payment Gateway';
                $shopCustomization->colorScheme = '#f3dc2a';

                $shopCustomization->set();

                $item_name = $activity->title;
                $total_price = $reg_fee;

                $user_phone = $user->contact_number;
                $user_email = $user->email;

                $reference_number = $requestReferenceNumber;

                // Item
                $itemAmountDetails = new ItemAmountDetails();
                $itemAmountDetails->tax = "0.00";
                $itemAmountDetails->subtotal = number_format($total_price, 2, '.', '');
                $itemAmount = new ItemAmount();
                $itemAmount->currency = "PHP";
                $itemAmount->value = $itemAmountDetails->subtotal;
                $itemAmount->details = $itemAmountDetails;
                $item = new Item();
                $item->name = $item_name;
                $item->amount = $itemAmount;
                $item->totalAmount = $itemAmount;

                // Checkout
                $itemCheckout = new Checkout();

                $user = new PayMayaUser();
                $user->contact->phone = $user_phone;
                $user->contact->email = $user_email;

                $itemCheckout->buyer = $user->buyerInfo();
                $itemCheckout->items = array($item);
                $itemCheckout->totalAmount = $itemAmount;
                $itemCheckout->requestReferenceNumber = $reference_number;
                $itemCheckout->redirectUrl = array(
                    "success" => route('checkout.success'),
                    "failure" => route('checkout.failure'),
                    "cancel" => url('/paymaya/checkout/cancel'),
                );

                if ($itemCheckout->execute() === false) {
                    $error = $itemCheckout::getError();
                    return redirect()->back()->withErrors(['message' => $error]);
                }

                if ($itemCheckout->retrieve() === false) {
                    $error = $itemCheckout::getError();
                    return redirect()->back()->withErrors(['message' => $error]);
                }

                return redirect()->to($itemCheckout->url)->with('data', $itemCheckout->retrieve());
            }
        }
    }

    public function checkoutSuccess(Request $request)
    {
        $data = $request->session()->get('data');

        $transaction_id = $data['id'];

        PayMayaSDK::getInstance()->initCheckout(
            config('paymaya.public_key'),
            config('paymaya.secret_key'),
            (app()->environment('production') ? 'PRODUCTION' : 'SANDBOX')
        );

        if (!$transaction_id) {
            return ['status' => false, 'message' => 'Transaction Id Missing'];
        }

        $itemCheckout = new Checkout();
        $itemCheckout->id = $transaction_id;

        $checkout = $itemCheckout->retrieve();

        if ($checkout === false) {
            $error = $itemCheckout::getError();
            return redirect()->back()->withErrors(['message' => $error]);
        }

        $payment_status = $checkout['paymentStatus'];
        $title = $checkout['items']['0']['name'];

        if ($payment_status === "PAYMENT_SUCCESS") {
            $ref_number = $checkout['requestReferenceNumber'];
            $receipt_number = $checkout['receiptNumber'];
            $buyer = $data['buyer'];
            $contact = $buyer['contact'];
            $email = $contact['email'];

            $user = User::where('email', $email)->first();
            $activity = Activity::where('title', $title)->first();

            $user_id = $user->id;
            $activity_id = $activity->id;

            Registration::create([
                'activity_id' => $activity_id,
                'user_id' => $user_id,
                'ref_number' => $ref_number,
                'receipt_number' => $receipt_number,
                'payment' => 'Paid',
            ]);

        }

        return view('payments.success', [
            'id' => $activity_id
        ]);
    }

    public function checkoutFailure(Request $request)
    {
        $sessions = $request->session()->all();
        $data = $request->session()->get('data');

        $transaction_id = $data['id'];

        PayMayaSDK::getInstance()->initCheckout(
            config('paymaya.public_key'),
            config('paymaya.secret_key'),
            (app()->environment('production') ? 'PRODUCTION' : 'SANDBOX')
        );

        if (!$transaction_id) {
            return ['status' => false, 'message' => 'Transaction Id Missing'];
        }

        $itemCheckout = new Checkout();
        $itemCheckout->id = $transaction_id;

        $checkout = $itemCheckout->retrieve();

        if ($checkout === false) {
            $error = $itemCheckout::getError();
            return redirect()->back()->withErrors(['message' => $error]);
        }

        return view('payments.failed');
    }

    public function checkoutCancel(Request $request)
    {
        $sessions = $request->session()->all();
        $data = $request->session()->get('data');

        $buyer = $data['buyer'];
        $contact = $buyer['contact'];
        $email = $contact['email'];

        dd($email);

        $transaction_id = $data['id'];

        PayMayaSDK::getInstance()->initCheckout(
            config('paymaya.public_key'),
            config('paymaya.secret_key'),
            (app()->environment('production') ? 'PRODUCTION' : 'SANDBOX')
        );

        if (!$transaction_id) {
            return ['status' => false, 'message' => 'Transaction Id Missing'];
        }

        $itemCheckout = new Checkout();
        $itemCheckout->id = $transaction_id;

        $checkout = $itemCheckout->retrieve();

        if ($checkout === false) {
            $error = $itemCheckout::getError();
            return redirect()->back()->withErrors(['message' => $error]);
        }

        return view('payments.cancelled');
    }
}
