<?php

namespace App\Http\Controllers;

use App\Models\Handmaids;
use App\Models\Registration;
use App\Models\Tithe;
use App\Models\User;
use App\Notifications\HandmaidsNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class HandmaidsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-member|create-member|edit-member|delete-member', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-member', ['only' => ['create', 'store', 'edit', 'update']]);
        $this->middleware('permission:edit-member', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-member', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('section_id', '5')->get();

            return DataTables::of($data)
                ->addIndexColumn()
            // ->addColumn('household_servant', '{{$household_servant_name}}')
                ->addColumn("actions", function ($info) {
                    $editButton = '<a href="handmaids/' . $info->id . '/edit" class="btn btn-outline-info btn-sm"><i class="tf-icons mdi mdi-pencil"></i></a>';
                    $deleteButton = '<a href="javascript:void(0);" id="' . $info->id . '" class="btn btn-outline-danger remove-btn btn-sm"><i class="tf-icons mdi mdi-trash-can"></i></a>';
                    $viewButton = '<a href="handmaids/' . $info->id . '" class="btn btn-outline-primary btn-sm"><i class="tf-icons mdi mdi-eye"></i></a>';
                    // Check user role before adding edit and delete buttons
                    if (Auth::user()->role_id == '1' || Auth::user()->role_id == '2') {
                        return '<div class="dropdown flex gap-2">'. $viewButton . $editButton . $deleteButton . '</div>';
                    } else {
                        // Default case for users with no edit/delete permissions
                        return '<div class="dropdown">' . $viewButton . '</div>';
                    }
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('handmaids.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('handmaids.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|regex:/^[A-Za-z\s\.\-]+$/',
            'email' => 'required|email|unique:users',
            'username' => 'required',
            'contact_number' => 'required|regex:/^[0-9\s\-\+\(\)]+$/',
            'gender' => 'required',
            'area' => 'required',
            'chapter' => 'required',
            'password' => 'nullable',
            'avatar' => 'nullable',
            'address' => 'required',
            'bio' => 'nullable|regex:/^[0-9\s\-\+\(\)]+$/',
            'nickname' => 'nullable|regex:/^[0-9\s\-\+\(\)]+$/',
            'birthday' => 'nullable',
        ]);

        $data['status'] = 'Active';
        $data['password'] = bcrypt('MFCPortal123!');

        $handmaids = User::create(array_merge($data, ['section_id' => '1', 'role_id' => '7']))->assignRole('Member');

        if ($request->hasFile('avatar')) {
            $filename = 'avatars/' . time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $handmaids->avatar = $filename;
            $handmaids->save();
            $request->file('avatar')->move(public_path('avatars'), $filename);
        }

        // Notification
        // $target = User::whereHas('roles', function ($query) {
        //     $query->whereIn('id', [1, 2]); // Use whereIn for multiple IDs
        // })->get();

        // Notification::send($target, new KidsNotification($kid, 'New Kids profile has been created!'));

        return redirect()->route('kids.edit', [
            'handmaids' => $handmaids->id,
        ])->with('success', 'Profile created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $handmaids = User::find($id);

        $dateOfBirth = $handmaids->birthday;
        $years = Carbon::parse($dateOfBirth)->age;

        $role_id = $handmaids->role_id;
        $role = Role::find($role_id);

        $tithes = Tithe::where('user_id', $id)->count();
        $events = Registration::where('user_id', $id)->count();

        return view('handmaids.show', [
            'id' => $id,
            'handmaids' => $handmaids,
            'age' => $years,
            'role' => $role,
            'events' => $events,
            'tithes' => $tithes,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $handmaids = User::find($id);

        $dateOfBirth = $handmaids->birthday;
        $years = Carbon::parse($dateOfBirth)->age;

        $role_id = $handmaids->role_id;
        $role = Role::find($role_id);

        $tithes = Tithe::where('user_id', $id)->count();
        $events = Registration::where('user_id', $id)->count();

        return view('handmaids.edit', [
            'id' => $id,
            'handmaids' => $handmaids,
            'age' => $years,
            'role' => $role,
            'events' => $events,
            'tithes' => $tithes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->ajax()) {
            $data = $request->validate([
                'name' => 'required|regex:/^[A-Za-z\s\.\-]+$/',
                'email' => 'required|email',
                'nickname' => 'required|regex:/^[A-Za-z\s\.\-]+$/',
                'username' => 'required',
                'address' => 'required',
                'bio' => 'required',
                'contact_number' => 'required|regex:/^[0-9\s\-\+\(\)]+$/',
                'gender' => 'required',
                'area' => 'required',
                'chapter' => 'required',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'birthday' => 'required',
                'email_verified_at' => 'nullable',
            ], [
                'name.required' => 'Please provide your full name',
                'email.required' => 'Please provide your email address',
                'nickname.required' => 'Please provide your nickname',
                'username.required' => 'Please provide your username',
                'address.required' => 'Please provide your home address',
                'bio.required' => 'Tell us about yourself',
                'contact_number.required' => 'Please provide your contact number',
                'gender.required' => 'Please select atleast 1',
                'area.required' => 'Please select atleast 1',
                'chapter.required' => 'Please select atleast 1',
                'birthday.required' => 'When is your birthday?',
                'name.regex' => 'Input was invalid',
                'nickname.regex' => 'Input was invalid',
                'email.email' => 'Input was invalid',
            ]);

            $data['email_verified_at'] = Carbon::now()->tz('Asia/Manila')->format('Y-m-d H:i:s');

            $user = User::findOrFail($id);
            $update = $user->update($data);

            $oldAvatarPath = $user->avatar;

            if ($request->hasFile('avatar')) {
                // Handle the new avatar upload as you've implemented
                $avatar = $request->file('avatar');
                $filename = 'avatars/' . time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('avatars'), $filename);

                // Update the newMember's avatar with the new file path
                $user->avatar = $filename;
                $user->save();

                // Delete the old avatar file if it exists
                if ($oldAvatarPath && file_exists(public_path($oldAvatarPath))) {
                    unlink(public_path($oldAvatarPath));
                }
            }

            if ($update) {
                return response()->json(['message' => 'Updated Successfully', 'data' => $data], 200);
            }

        }

        abort(404);
    }

    public function updatePassword(Request $request, string $id)
    {
        if ($request->ajax()) {
            // Validate input
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8',
                'confirm_password' => 'required|same:new_password',
            ], [
                'current_password.required' => 'Current password is required',
                'new_password.required' => 'New password is required',
                'new_password.min' => 'New password must be at least 8 characters',
                'new_password.different' => 'New password and confirm password must be different',
                'confirm_password.required' => 'Confirm password is required',
                'confirm_password.same' => 'New password and Confirm password must be the same',
            ]);

            // Check if the entered current password matches the user's actual password
            $user = User::find($id);

            if (!Hash::check($request->input('current_password'), $user->password)) {
                return response()->json(['message' => "Current Password doesn't match in our records."], 500);
            }

            // If the current password is correct, proceed to update the password
            $user->password = bcrypt($request->input('new_password'));
            $user->save();

            return response()->json([
                'message' => 'Password Updated Successfully'
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = User::findOrFail($request->id);
        $remove = $data->delete();

        if ($remove) {
            DatabaseNotification::where('data->email', $data->email)->delete();
            return response([
                'status' => true,
                'message' => 'Profile deleted successfully'
            ]);
        } else {
            return response([
                'error' => true,
                'message' => 'Failed to delete Profile'
            ]);
        }
    }
}
