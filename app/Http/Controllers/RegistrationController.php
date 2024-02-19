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
        //
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
