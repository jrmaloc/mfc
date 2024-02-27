<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Tithe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

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
        $oneHourAgo = now()->subHour();
        $userCount = User::where('status', 'Active')->count();
        $announcementCount = Announcement::count();
        $adminCount = User::role('Admin', 'web')->count(); // Count of users with the admin role
        $tithes = Tithe::count(); // Total
        $events = Activity::where('start_date', '>=', now())->count();
        $upcomingEvents = Activity::where('start_date', '>=', now())->where('end_date', '<=', now()->addWeeks(2))->get();
        $user = Auth::user();
        $bio = $user->bio;
        $userID = $user->id;
        $newUsersCount = User::where('created_at', '>=', $oneHourAgo)->count();

        $id = $user->role_id;

        $role = Role::findOrFail($id);

        $amount = Tithe::sum('amount');

        return view('dashboard', compact(
            'userCount',
            'events',
            'upcomingEvents',
            'tithes',
            'newUsersCount',
            'role',
            'announcementCount',
            'bio',
            'amount'
        ), [
            'user' => $user,
            'id' => $userID,
        ]);
    }

    public function bio(Request $request)
    {
        $user = User::findOrFail($request->id);

        $bio = $user->update([
            'bio' => $request->bio,
        ]);

        $newBio = $user->bio;

        if ($bio) {
            return response()->json(['bio' => $newBio, 'success' => 'Bio Updated Successfully'], 200);
        } else {
            return response()->json(['error' => 'Bio did not saved'], 404);
        }
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
