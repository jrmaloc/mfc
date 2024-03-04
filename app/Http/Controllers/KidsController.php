<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Registration;
use App\Models\Tithe;
use App\Models\User;
use App\Notifications\KidsNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class KidsController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('permission:view-member|create-member|edit-member|delete-member', ['only' => ['index', 'store', 'create', 'update', 'edit', 'destroy', 'show']]);
    //     $this->middleware('permission:create-member', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:edit-member', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:delete-member', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('section_id', '=', 1)->get();

            return DataTables::of($data)
                ->addIndexColumn()
            // ->addColumn('household_servant', '{{$household_servant_name}}')
                ->addColumn("actions", function ($info) {
                    $editButton = '<a href="kids/' . $info->id . '/edit" class="mr-2 btn btn-outline-info btn-sm"><i class="tf-icons mdi mdi-pencil"></i></a>';
                    $deleteButton = '<a href="javascript:void(0);" id="' . $info->id . '" class="btn btn-outline-danger remove-btn btn-sm"><i class="tf-icons mdi mdi-trash-can"></i></a>';
                    $viewButton = '<a href="kids/' . $info->id . '" class="mr-2 btn btn-outline-primary btn-sm"><i class="tf-icons mdi mdi-eye"></i></a>';
                    // Check user role before adding edit and delete buttons
                    if (Auth::user()->roles->first()->name == 'Admin' || Auth::user()->roles->first()->name == 'Super Admin') {
                        return '<div class="dropdown">' . $viewButton . $editButton . $deleteButton . '</div>';
                    } elseif (Auth::user()->role == 'editor' && $info->editableByEditor()) {
                        // Additional check if the user has permission to edit this specific item
                        return '<div class="dropdown">' . $viewButton . $editButton . '</div>';
                    } else {
                        // Default case for users with no edit/delete permissions
                        return '<div class="dropdown">' . $viewButton . '</div>';
                    }
                })
                ->rawColumns(['actions'])

                ->make(true);
        }

        return view('kids.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kids.create');
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
            'nickname' => 'nullable',
            'birthday' => 'nullable',
        ]);

        $data['status'] = 'Active';
        $data['password'] = bcrypt('MFCPortal123!');

        $kid = User::create(array_merge($data, ['section_id' => '1', 'role_id' => '7']))->assignRole('Member');

        if ($request->hasFile('avatar')) {
            $filename = 'avatars/' . time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $kid->avatar = $filename;
            $kid->save();
            $request->file('avatar')->move(public_path('avatars'), $filename);
        }

        // Notification
        // $target = User::whereHas('roles', function ($query) {
        //     $query->whereIn('id', [1, 2]); // Use whereIn for multiple IDs
        // })->get();

        // Notification::send($target, new KidsNotification($kid, 'New Kids profile has been created!'));

        return redirect()->route('kids.edit', [
            'kid' => $kid->id,
        ])->with('success', 'Profile created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kid = User::find($id);

        $dateOfBirth = $kid->birthday;
        $years = Carbon::parse($dateOfBirth)->age;

        $role_id = $kid->role_id;
        $role = Role::find($role_id);

        $tithes = Tithe::where('user_id', $id)->count();
        $events = Registration::where('user_id', $id)->count();

        return view('kids.show', [
            'id' => $id,
            'kid' => $kid,
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
        $kid = User::find($id);

        $dateOfBirth = $kid->birthday;
        $years = Carbon::parse($dateOfBirth)->age;

        $role_id = $kid->role_id;
        $role = Role::find($role_id);

        $tithes = Tithe::where('user_id', $id)->count();
        $events = Registration::where('user_id', $id)->count();

        return view('kids.edit', [
            'id' => $kid->id,
            'kid' => $kid,
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
                'nickname' => 'nullable',
                'username' => 'required',
                'address' => 'required',
                'bio' => 'required',
                'contact_number' => 'required|regex:/^[0-9\s\-\+\(\)]+$/',
                'gender' => 'required',
                'area' => 'required',
                'chapter' => 'required',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

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

        $data = $request->validate([
            'name' => 'required|regex:/^[A-Za-z\s\.\-]+$/',
            'email' => 'required',
            'nickname' => 'nullable',
            'username' => 'required',
            'address' => 'required',
            'bio' => 'required',
            'contact_number' => 'required|regex:/^[0-9\s\-\+\(\)]+$/',
            'gender' => 'required',
            'area' => 'required',
            'chapter' => 'required',
            'avatar' => 'nullable',
        ]);

        $status = $request->has('status') ? 'Active' : 'Inactive';
        $data['status'] = $status;

        $kid = User::find($id);
        $kid->update($data);

        $oldAvatarPath = $kid->avatar; // Get the old avatar path before updating

        if ($request->hasFile('avatar')) {
            // Handle the new avatar upload as you've implemented
            $avatar = $request->file('avatar');
            $filename = 'avatars/' . time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('avatars'), $filename);

            // Update the newMember's avatar with the new file path
            $kid->avatar = $filename;
            $kid->save();

            // Delete the old avatar file if it exists
            if ($oldAvatarPath && file_exists(public_path($oldAvatarPath))) {
                unlink(public_path($oldAvatarPath));
            }
        }

        return redirect(route('kids.edit', ['kid' => $kid->id]))->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request, string $id)
    {
        $kid = User::find($id);
        try {
            // Validate input
            $data = $request->validate([
                'current_pass' => 'required',
                'new_pass' => 'required|min:8|different:current_pass',
                'confirm_pass' => 'required|same:new_pass',
            ]);

            // Check if the entered current password matches the user's actual password
            if (!Hash::check($request->input('current_pass'), $kid->password)) {
                return redirect()->back()->withErrors(['current_pass' => 'Credentials is incorrect.']);
            }

            // If the current password is correct, proceed to update the password
            $kid->password = bcrypt($request->input('new_pass'));
            $kid->user->password = bcrypt($request->input('new_pass'));

            $kid->update($data);

            return response()->json([
                'success' => 'Password updated successfully',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // If validation fails, handle the exception here
            session()->flash('error', 'There was an error in the form submission.');
            return redirect()->back()->withErrors($e->validator)->withInput();
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
