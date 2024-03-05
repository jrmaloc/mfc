<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Tithe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class YouthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('section_id', '2')->get();

            return DataTables::of($data)
                ->addIndexColumn()
            // ->addColumn('household_servant', '{{$household_servant_name}}')
                ->addColumn("actions", function ($info) {
                    $editButton = '<a href="youth/' . $info->id . '/edit" class="btn btn-outline-info btn-sm"><i class="tf-icons mdi mdi-pencil"></i></a>';
                    $deleteButton = '<a href="javascript:void(0);" id="' . $info->id . '" class="btn btn-outline-danger remove-btn btn-sm"><i class="tf-icons mdi mdi-trash-can"></i></a>';
                    $viewButton = '<a href="youth/' . $info->id . '" class="btn btn-outline-primary btn-sm"><i class="tf-icons mdi mdi-eye"></i></a>';
                    // Check user role before adding edit and delete buttons
                    if (Auth::user()->role_id == '2' || Auth::user()->role_id == '1') {
                        return '<div class="dropdown flex gap-2">' . $viewButton . $editButton . $deleteButton . '</div>';
                    } else {
                        // Default case for users with no edit/delete permissions
                        return '<div class="dropdown">' . $viewButton . '</div>';
                    }
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('youth.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('youth.create');
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
            'bio' => 'nullable',
            'nickname' => 'nullable|regex:/^[A-Za-z\s\.\-]+$/',
            'birthday' => 'nullable',
        ]);

        $data['status'] = 'Active';
        $data['password'] = bcrypt('MFCPortal123!');

        $youth = User::create(array_merge($data, ['section_id' => '2', 'role_id' => '7']))->assignRole('Member');

        if ($request->hasFile('avatar')) {
            $filename = 'avatars/' . time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $youth->avatar = $filename;
            $youth->save();
            $request->file('avatar')->move(public_path('avatars'), $filename);
        }

        // Notification

        // $target = User::whereHas('roles', function ($query) {
        //     $query->whereIn('id', [1, 2]); // Use whereIn for multiple IDs
        // })->get();

        // Notification::send($target, new YouthNotification($youth, 'New Youth Profile has been created!'));

        return redirect()->route('youth.edit', [
            'youth' => $youth->id,
        ])->with('success', 'Profile created successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $youth = User::find($id);

        $dateOfBirth = $youth->birthday;
        $years = Carbon::parse($dateOfBirth)->age;

        $role_id = $youth->role_id;
        $role = Role::find($role_id);

        $tithes = Tithe::where('user_id', $id)->count();
        $events = Registration::where('user_id', $id)->count();

        return view('youth.show', [
            'id' => $id,
            'youth' => $youth,
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
        $youth = User::find($id);

        $dateOfBirth = $youth->birthday;
        $years = Carbon::parse($dateOfBirth)->age;

        $role_id = $youth->role_id;
        $role = Role::find($role_id);

        $tithes = Tithe::where('user_id', $id)->count();
        $events = Registration::where('user_id', $id)->count();

        return view('youth.edit', [
            'id' => $id,
            'youth' => $youth,
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
                'email' => 'required',
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
            $data = $request->validate([
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
            $youth = User::find($id);

            if (!Hash::check($request->input('current_password'), $youth->password)) {
                return response()->json(['message' => "Current Password doesn't match in our records."], 500);
            }

            // If the current password is correct, proceed to update the password
            $youth->password = bcrypt($request->input('new_password'));
            $youth->save();

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
                'message' => 'Profile deleted successfully',
            ]);
        } else {
            return response([
                'error' => true,
                'message' => 'Failed to delete Profile',
            ]);
        }
    }
}
