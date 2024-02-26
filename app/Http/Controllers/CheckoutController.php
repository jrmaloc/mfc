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
use App\Mail\EventRegistration\Success;
use App\Models\Activity;
use App\Models\Registration;
use App\Models\Tithe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function initiateCheckout(Request $request)
    {

        $activity = Activity::find($request->id);
        $user = User::where('email', $request->email)->first();
        $reg_fee = $request->reg_fee;

        $prefix = 'payment_';
        $requestReferenceNumber = uniqid($prefix);

        if ($user) {
            $existingRegistration = Registration::where('activity_id', $request->id)
                ->where('user_id', $user->id)->where('payment_status', 'Paid')
                ->first();

            if ($existingRegistration) {
                return back()->with('error', 'User is already registered for this activity');
            } else {
                $pending = Registration::where('activity_id', $request->id)
                    ->where('user_id', $user->id)->where('payment_status', 'Pending')
                    ->first();
                $registered = '';
                if (!$pending) {
                    $registered = Registration::create([
                        'activity_id' => $activity->id,
                        'user_id' => $user->id,
                        'ref_number' => $requestReferenceNumber,
                        'payment' => 'Pending',
                    ]);
                } else {

                    $authorized = true;
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
                    $shopCustomization->colorScheme = '#0093f5ff';

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
                        "success" => route('checkout.success', [
                            'id' => $activity->id,
                            'name' => 'activity-payment',
                        ]),
                        "failure" => route('checkout.failure'),
                        "cancel" => route('checkout.cancel'),
                    );

                    if ($itemCheckout->execute() === false) {
                        $error = $itemCheckout::getError();
                        return back()->with('error', ['message' => $error]);
                    }

                    if ($itemCheckout->retrieve() === false) {
                        $error = $itemCheckout::getError();
                        // return redirect()->back()->withErrors(['message' => $error]);
                        return back()->with('error', ['message' => $error]);
                    }
                }
                return redirect()->to($itemCheckout->url)->with('data', $itemCheckout->retrieve());
            }
        }
        return back()->with('error', 'Registration Failed');
    }

    public function tithesCheckout(Request $request)
    {

        $servant = User::where('email', $request->email)->first();
        $reg_fee = $request->amount;

        $prefix = 'tithes_';
        $requestReferenceNumber = uniqid($prefix);

        if ($servant) {
            // Initialize PayMaya SDK for checkout
            PayMayaSDK::getInstance()->initCheckout(
                config('paymaya.public_key'),
                config('paymaya.secret_key'),
                app()->environment('production') ? 'PRODUCTION' : 'SANDBOX'
            );

            $item_name = $request->name;
            $total_price = $reg_fee;

            $servant_phone = $servant->contact_number;
            $servant_email = $servant->email;

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
            $user->contact->phone = $servant->phone;
            $user->contact->email = $servant->email;

            $itemCheckout->buyer = $user->buyerInfo();
            $itemCheckout->items = array($item);
            $itemCheckout->totalAmount = $itemAmount;
            $itemCheckout->requestReferenceNumber = $reference_number;
            $itemCheckout->redirectUrl = array(
                "success" => route('checkout.success', [
                    'id' => $servant->id,
                    'name' => 'tithes-payment',
                ]),
                "failure" => route('checkout.failure'),
                "cancel" => route('checkout.cancel'),
            );

            if ($itemCheckout->execute() === false) {
                $error = $itemCheckout::getError();
                return back()->with('error', ['message' => $error]);
            }

            if ($itemCheckout->retrieve() === false) {
                $error = $itemCheckout::getError();
                // return redirect()->back()->withErrors(['message' => $error]);
                return back()->with('error', ['message' => $error]);
            }

            return redirect()->to($itemCheckout->url)->with('data', $itemCheckout->retrieve());
        }
        return back()->with('error', 'Registration Failed');
    }

    public function checkoutSuccess(Request $request, string $id)
    {
        $query = $request->query->all()['name'];

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

        if ($query == 'activity-payment') {
            $activity = Activity::find($id);

            $payment_status = $checkout['paymentStatus'];

            if ($payment_status === "PAYMENT_SUCCESS") {
                $receipt_number = $checkout['receiptNumber'];
                $email = $data['buyer']['contact']['email'];

                $activity_id = $activity->id;
                $start_date = $activity->start_date;
                $end_date = $activity->end_date;

                $user = User::where('email', $email)->first();
                $registrations = Registration::where('activity_id', $id)->where('user_id', $user->id)->get();

                $data = [
                    'receipt_number' => $receipt_number,
                    'payment_status' => 'Paid',
                ];

                foreach ($registrations as $registration) {
                    $registered = $registration->update($data);

                    if ($registered) {
                        $start = Carbon::parse($start_date)->format('F d, Y \\@ h:i A');
                        $end = Carbon::parse($end_date)->format('F d, Y \\@ h:i A \\(l\\)');
                        Mail::to($email)->send(new Success($activity, $start, $end));
                    }
                }
            }

            return view('payments.success', [
                'id' => $activity_id,
            ]);

        } else if ($query == 'tithes-payment') {
            $payment_status = $checkout['paymentStatus'];

            if ($payment_status === "PAYMENT_SUCCESS") {
                $receipt_number = $checkout['receiptNumber'];
                $transaction_id = $checkout['requestReferenceNumber'];
                $email = $data['buyer']['contact']['email'];
                $amount = $data['items'][0]['amount']['value'];

                // Find the user by email
                $user = User::where('email', $email)->first();

                if ($user) {
                    $user_id = $user->id;

                    $newTithe = Tithe::create([
                        'user_id' => $user_id,
                        'amount' => $amount,
                        'transaction_id' => $transaction_id,
                        'receipt_number' => $receipt_number,
                    ]);

                    if ($newTithe) {
                        // Mail::to($email)->send(new TitheSuccess($newTithe));
                        return view('tithes.success');
                    }
                }
            }
        }
    }

    public function checkoutFailure(Request $request)
    {
        $query = $request->query->all()['name'];
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

        if ($query = 'activity-payment') {
            $title = $checkout['items']['0']['name'];
            $activity = Activity::where('title', $title)->first();

            return view('payments.failed', [
                'id' => $activity->id,
            ]);
        } else if ($query = 'tithes-payment') {
            return view('tithes.failed');
        }
    }

    public function checkoutCancel(Request $request)
    {
        $query = $request->query->all()['name'];
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

        if ($query = 'activity-payment') {
            $title = $checkout['items']['0']['name'];
            $activity = Activity::where('title', $title)->first();

            return view('payments.cancelled', [
                'id' => $activity->id,
            ]);
        } else if ($query = 'tithes-payment') {
            return view('tithes.cancelled');
        }
    }
}
