<?php

namespace App\Http\Controllers;


use App\Models\Activity;
use App\Models\Tithe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); // Apply auth middleware to this controller
        $this->middleware('permission:view-dashboard|create-dashboard|edit-dashboard|delete-dashboard', ['only' => ['index']]);
        $this->middleware('permission:create-dashboard', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-dashboard', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-dashboard', ['only' => ['destroy']]);
    }

    public function index()
    {
        $userCount = User::count(); // Total users
        $adminCount = User::role('Admin', 'web')->count(); // Count of users with the admin role
        $tithes = Tithe::count(); // Total
        $events = Activity::count();
        // $householdCount = User::role('household')->count(); //
        // Retrieve the authenticated user
        $user = Auth::user();
        $userID = $user->id;
        return view('dashboard', compact('userCount', 'events', 'tithes'), [
            'user' => $user,
            'id' => $userID,
        ]);
    }

    public function markNotification(Request $request)
    {
        Auth::user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();

    }

    public function unmarkNotification(Request $request)
    {
        Auth::user()
            ->readNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsUnread();

        return response()->noContent();

    }
}
