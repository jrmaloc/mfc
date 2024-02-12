<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Registration;
use App\Models\User;
use App\Notifications\EventNotification;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("actions", function ($activity) {
                    return '<div class="dropdown">
                    <a href="javascript:void(0);" onclick="show()" data-id="' . $activity->id . '" class="btn btn-primary attendees btn-sm" style="text-transform: capitalize !important">Attendees</a>
                    <a href="javascript:void(0);" id="' . $activity->id . '" class="btn btn-outline-danger remove-btn btn-sm"><i class="tf-icons mdi mdi-trash-can"></i></a>
                    </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('activities.activities');
    }

    public function registration(Request $request, string $id)
    {
        dd($request->all());
        $client = new Client();

        $response = $client->request('POST', 'https://pg-sandbox.paymaya.com/checkout/v1/checkouts', [
            'body' => '{"totalAmount":{"value":1000,"currency":"PHP"},"requestReferenceNumber":"5fc10b93-bdbd-4f31-b31d-4575a3785009"}',
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic cGstZW80c0wzOTNDV1U1S212ZUpVYVc4VjczMFRUZWkyelk4ekU0ZEhKRHhrRjpHb2Rlc3EyMDIxIQ==',
                'content-type' => 'application/json',
            ],
        ]);

        // Assuming the API response is successful and returns a JSON object
        $result = $response->getBody();
        $data = json_decode($result);

        $redirectUrl = $data->redirectUrl;

        return redirect()->to($redirectUrl);

        // $name = $request->name;
        // $attendee = User::where('name', $name)->first();

        // if (!$attendee) {
        //     $user = User::create([
        //         'name' => $name,
        //         'email' => $request->email,
        //         'contact_number' => $request->contact_number,
        //         'password' => 'password',
        //     ]);
        // }

        // $data = [
        //     'activity_id' => $id,
        //     'ref_number' => $request->ref_number,
        //     'paid' => 'Paid',
        // ];

        // $user_id = $attendee->id;
        // $register = Registration::create(array_merge($data, ['user_id' => $user_id]));

        // if ($register) {
        //     return response()->json(['success' => true, 'message' => 'Registration successful']);
        // } else {
        //     return response()->json(['success' => false, 'message' => 'Registration failed']);
        // }
    }

    public function attendees(Request $request, string $id)
    {
        $activity = Activity::findOrFail($id);
        $attendees = Registration::where('activity_id', $id)->get();
        $user_ids = [];

        foreach ($attendees as $attendee) {
            $user_ids[] = $attendee->user_id;
        }

        if ($request->ajax()) {
            $data = Registration::where('activity_id', $id)
                ->with('user')
                ->whereHas('user', function ($query) use ($user_ids) {
                    $query->whereIn('id', $user_ids);
                })
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function redirect()
    {
        $user = Auth::user();

        // Retrieve roles as a collection of role names
        $roles = $user->getRoleNames();

        if ($roles->contains('Admin') || $roles->contains('Super Admin')) {
            return redirect(route('dashboard'));
        } else {
            return redirect(route('announcements.index'));
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $user = Auth::user();
        $activities = Activity::all();
        $userID = $user->id;
        $role = $user->role_id;
        $events = [];

        foreach ($activities as $activity) {
            $targetAudience = json_decode($activity->role_ids, true);
            if (in_array($role, $targetAudience)) {

                // Format start and end dates to ISO 8601 format
                $startISO8601 = date('Y-m-d\TH:i:s', strtotime($activity->start_date));
                $endISO8601 = date('Y-m-d\TH:i:s', strtotime($activity->end_date));

                // Common event properties
                $event = [
                    'user_id' => $userID,
                    'id' => $activity->id,
                    'title' => $activity->title,
                    'description' => $activity->description,
                    'location' => $activity->location,
                    'start' => $startISO8601,
                    'end' => $endISO8601,
                    'reg_fee' => $activity->reg_fee,
                ];

                // Additional properties for specific activities
                if ($activity->title == 'Liturgical Bible Study') {
                    $start = '18:45:00';
                    $startISO8601 = date('Y-m-d\TH:i:s', strtotime($activity->start_date)) . $start;

                    $date = Carbon::parse($activity->start_date);
                    $dayOfWeek = $date->dayOfWeek;
                    $event = [
                        'user_id' => $userID,
                        'id' => $activity->id,
                        'title' => $activity->title,
                        'description' => $activity->description,
                        'location' => $activity->location,
                        'start' => $startISO8601,
                        'end' => $startISO8601,
                        'groupId' => 'blueEvents',
                        // 'selectable' => false,
                        // 'editable' => false,
                        'daysOfWeek' => [$dayOfWeek],
                    ];
                }

                $events[] = $event;
            }
        }
        return view('activities.calendar')->with('events', $events);
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
        $data = $request->validate([
            'title' => 'required|unique:activities',
            'description' => 'required',
            'location' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reg_fee' => 'required|regex:/^[0-9]+(?:\.[0-9]{1,2})?$/',
        ]);

        $startDate = $data['start_date'];
        $endDate = $data['end_date'];

        $formatStartDate = Carbon::parse($startDate)->format('Y-m-d H:i:s');
        $formatEndDate = Carbon::parse($endDate)->format('Y-m-d H:i:s');

        $role_ids = ['role_ids' => '[1, 2, 3, 4, 5, 6, 7]'];

        $activity = Activity::create(array_merge($role_ids, $data, ['start_date' => $formatStartDate, 'end_date' => $formatEndDate]));

        $roles = Role::all();

        $admins = User::whereHas('roles', function ($query) use ($roles) {
            $query->whereIn('id', $roles->pluck('id'));
        })->get();

        Notification::send($admins, new EventNotification($activity, 'New Event has been created!'));

        return response()->json($activity);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $activity = Activity::findOrFail($id);
        $user = Auth::user();

        $lbs = Activity::where('title', 'Liturgical Bible Study')->first();

        if ($activity->title === $lbs->title) {
            $data = $request->query('start');

            $start = Carbon::parse($data)->add('1 day')->format('M d, Y') . ' ' . Carbon::parse($activity->start_date)->format('h:iA');
            $end = Carbon::parse($start)->addHours(2)->addMinutes(15)->format('M d, Y h:iA');

            return view('activities.show', [
                'id' => $id,
                'start_date' => $start,
                'end_date' => $end,
                'activity' => $activity,
            ]);
        } else {
            $info = $activity->start_date;
            $info2 = $activity->end_date;

            $start_date = Carbon::parse($info)->format('M d, Y h:iA');
            $end_date = Carbon::parse($info2)->format('M d, Y h:iA');

            return view('activities.show', [
                'id' => $id,
                'user' => $user,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'activity' => $activity,
            ]);
        }

        if ($request->ajax()) {
            return response()->json(['redirect' => route('calendar.show', ['id' => $id])]);
        };
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
    public function update(Request $request, $id)
    {
        $activity = Activity::find($id);

        if (!$activity) {
            return response()->json([
                'error' => 'Unable to find activity',
            ], 404);
        }

        $data = $request->validate([
            'description' => 'required',
            'location' => 'required',
            'reg_fee' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $startDate = $data['start_date'];
        $endDate = $data['end_date'];

        $formattedStartDate = Carbon::parse($startDate)->format('Y-m-d H:i:s');
        $formattedEndDate = Carbon::parse($endDate)->format('Y-m-d H:i:s');

        $data['start_date'] = $formattedStartDate;
        $data['end_date'] = $formattedEndDate;

        $activity->update($data);

        $roles = Role::all();

        $admins = User::whereHas('roles', function ($query) use ($roles) {
            $query->whereIn('id', $roles->pluck('id'));
        })->get();

        Notification::send($admins, new EventNotification($activity, 'An Event has been updated!'));

        return redirect()->route('calendar.show', ['id' => $id])->with('success', 'Activity Updated Successfully');
    }

    public function dragEvent(Request $request, $id)
    {
        $activity = Activity::find($id);
        $lbs = Activity::find(13);

        if (!$activity) {
            return response()->json([
                'error' => 'Unable to find activity',
            ], 404);
        }

        if ($activity->title == $lbs->title) {
            $start_date = $request->start_date;

            $act_start = Carbon::parse($activity->start_date);

            $hour = $act_start->hour;
            $minute = $act_start->minute;
            $second = $act_start->second;

            $newStart_date = Carbon::parse($start_date);
            $newStart_date->setTime($hour, $minute, $second);
            $newStart_date_formatted = $newStart_date->format('Y-m-d H:i:s');

            $newEnd_date = $newStart_date->copy()->addHours(2);

            $save = $activity->update([
                'start_date' => $newStart_date_formatted,
                'end_date' => $newEnd_date->format('Y-m-d H:i:s'),
            ]);

        } else {
            $save = $activity->update([
                'start_date' => Carbon::parse($request->input('start_date')),
                'end_date' => Carbon::parse($request->input('end_date')),
            ]);
        }

        if ($save) {
            $roles = Role::all();

            $admins = User::whereHas('roles', function ($query) use ($roles) {
                $query->whereIn('id', $roles->pluck('id'));
            })->get();

            Notification::send($admins, new EventNotification($activity, 'An Event has been updated!'));
        }

        return response()->json([
            'message' => 'Event Changed Successfully!',
            'status' => 'success',
            'activity' => $activity,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $activity = Activity::findOrFail($id);

        $remove = $activity->delete();

        if ($remove) {

            DatabaseNotification::where('data->event_id', $id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Event Deleted Successfully',
                'redirect' => route('calendar.list'),
            ]);
        }
    }
}
