<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\EventRegistrationMail;
use App\Models\Activity;
use App\Models\Registration;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            }

            $data['activity_id'] = $request->id;
            $data['user_id'] = $user->id;
            $data['ref_number'] = '';
            $data['paid'] = 'Pending';

            $register = Registration::create($data);

            if ($register) {

                $recipient = $user->email;

                $start = $activity->start_date;
                $end = $activity->end_date;

                $start_date = Carbon::parse($start)->toDayDateTimeString();
                $end_date = Carbon::parse($end)->toDayDateTimeString();

                Mail::to($recipient)->send(new EventRegistrationMail($activity, $start_date, $end_date));

                // return redirect()->route('calendar.show', [
                //     'id' => $activity->id,
                // ])->with('success', 'Registration successful');

                $client = new Client();

                try {
                    $response = $client->request('POST', 'https://pg-sandbox.paymaya.com/checkout/v1/checkouts', [
                        'json' => [
                            'totalAmount' => [
                                'value' => $reg_fee,
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

        return back()->with('error', 'Registration failed');
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
