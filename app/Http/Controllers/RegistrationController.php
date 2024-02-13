<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\User;

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
        $user = User::where('name', $request->name)->first();

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
                // $recipient = User::where('user_id', $user->id)->first();
                return redirect()->route('calendar.show', [
                    'id' => $activity->id,
                ])->with('success', 'Registration successful');
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
