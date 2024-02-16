<?php

namespace App\Http\Controllers;

use Aceraven777\PayMaya\API\Checkout;
use Aceraven777\PayMaya\API\Webhook;
use Aceraven777\PayMaya\Model\Checkout\Item;
use Aceraven777\PayMaya\Model\Checkout\ItemAmount;
use Aceraven777\PayMaya\Model\Checkout\ItemAmountDetails;
use Aceraven777\PayMaya\PayMayaSDK;
use App\Http\Controllers\Controller;
use App\Libraries\PayMaya\User as PayMayaUser;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $activity = Activity::find($request->id);
        // $user = User::where('email', $request->email)->first();
        // $reg_fee = $request->reg_fee;
        // $prefix = 'payment_';
        // $requestReferenceNumber = uniqid($prefix);

        // if ($user) {
        //     $existingRegistration = Registration::where('activity_id', $request->id)
        //         ->where('user_id', $user->id)
        //         ->first();

        //     if ($existingRegistration) {
        //         return back()->with('error', 'User is already registered for this activity');
        //     }

        //     $data['activity_id'] = $request->id;
        //     $data['user_id'] = $user->id;
        //     $data['ref_number'] = '';
        //     $data['paid'] = 'Pending';

        //     $register = Registration::create($data);

        //     if ($register) {

        //         $recipient = $user->email;

        //         $start = $activity->start_date;
        //         $end = $activity->end_date;

        //         $start_date = Carbon::parse($start)->toDayDateTimeString();
        //         $end_date = Carbon::parse($end)->toDayDateTimeString();

        //         Mail::to($recipient)->send(new EventRegistrationMail($activity, $start_date, $end_date));

        //         // return redirect()->route('calendar.show', [
        //         //     'id' => $activity->id,
        //         // ])->with('success', 'Registration successful');

        //         $client = new Client();

        //         try {
        //             $response = $client->request('POST', 'https://pg.paymaya.com/checkout/v1/checkouts', [
        //             // $response = $client->request('POST', 'https://pg-sandbox.paymaya.com/checkout/v1/checkouts', [
        //                 'json' => [
        //                     'totalAmount' => [
        //                         'value' => 1,
        //                         'currency' => 'PHP',
        //                     ],
        //                     'redirectURL' => [
        //                         'success' => route('checkout.success'),
        //                         'failure' => route('checkout.failure'),
        //                         'cancel' => route('checkout.cancel'),
        //                     ],
        //                     'requestReferenceNumber' => $requestReferenceNumber,
        //                 ],
        //                 'headers' => [
        //                     'accept' => 'application/json',
        //                     'authorization' => 'Basic cGstNDc2VHh6MGxrbWlQeVAxbWdDM0dzczdKakMxdEl5WjYxWGx1b29vdjBFRzpzay10NGwwVUpmUmVtWDQwVkVZRTROdlAwS01MRzB3YkF3a1lrUWhoSVN4Smx4',
        //                     // 'authorization' => 'Basic cGstWjBPU3pMdkljT0kyVUl2RGhkVEdWVmZSU1NlaUdTdG5jZXF3VUU3bjBBaDpzay1YOHFvbFlqeTYya0l6RWJyMFFSSzFoNGI0S0RWSGFOY3dNWWszOWpJblNs',
        //                     'content-type' => 'application/json',
        //                 ],
        //             ]);

        //             $responseData = json_decode($response->getBody()->getContents(), true);

        //             $checkoutId = $responseData['checkoutId'];

        //             if (isset($responseData['redirectUrl'])) {
        //                 $redirectURL = $responseData['redirectUrl'];
        //                 // Process $redirectURL as needed
        //                 return redirect($redirectURL);
        //             } else {
        //                 // Handle the case where redirectURL is not present in the response
        //             }
        //         } catch (\Exception $e) {
        //             // Handle exceptions here
        //             return $e->getMessage();
        //         }
        //     }
        // }

        // return back()->with('error', 'Registration failed');

// Initialize PayMaya SDK for checkout
        PayMayaSDK::getInstance()->initCheckout(
            config('paymaya.public_key'),
            config('paymaya.secret_key'),
            (app()->environment('production') ? 'PRODUCTION' : 'SANDBOX')
        );

        $sample_item_name = 'Product 1';
        $sample_total_price = 1000.00;

        $sample_user_phone = '1234567';
        $sample_user_email = 'test@gmail.com';

        $sample_reference_number = '1234567890';

        // Item
        $itemAmountDetails = new ItemAmountDetails();
        $itemAmountDetails->tax = "0.00";
        $itemAmountDetails->subtotal = number_format($sample_total_price, 2, '.', '');
        $itemAmount = new ItemAmount();
        $itemAmount->currency = "PHP";
        $itemAmount->value = $itemAmountDetails->subtotal;
        $itemAmount->details = $itemAmountDetails;
        $item = new Item();
        $item->name = $sample_item_name;
        $item->amount = $itemAmount;
        $item->totalAmount = $itemAmount;

        // Checkout
        $itemCheckout = new Checkout();

        $user = new PayMayaUser();
        $user->contact->phone = $sample_user_phone;
        $user->contact->email = $sample_user_email;

        $itemCheckout->buyer = $user->buyerInfo();
        $itemCheckout->items = array($item);
        $itemCheckout->totalAmount = $itemAmount;
        $itemCheckout->requestReferenceNumber = $sample_reference_number;
        $itemCheckout->redirectUrl = array(
            "success" => route('checkout.success'),
            "failure" => route('checkout.failure'),
            "cancel" => route('checkout.cancel'),
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = $request->id;
        $status = $request->status;
        if ($request->ajax()) {
            $registration = Registration::find($id);

            if ($request->status === 'true') {
                $registration->paid = "Paid";
                $registration->save();

                return response()->json(['message' => 'Registration updated successfully'], 200);
            } else {
                $registration->paid = "Pending";
                $registration->save();

                return response()->json(['message' => 'Registration updated successfully'], 200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
