<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ServantsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\DataTables;

class ServantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('section_id', '4')->get();

            return DataTables::of($data)
                ->addIndexColumn()
            // ->addColumn('household_servant', '{{$household_servant_name}}')
                ->addColumn("actions", function ($info) {
                    $editButton = '<a href="servants/' . $info->id . '/edit" class="btn btn-outline-info btn-sm"><i class="tf-icons mdi mdi-pencil"></i></a>';
                    $deleteButton = '<a href="javascript:void(0);" id="' . $info->id . '" class="btn btn-outline-danger remove-btn btn-sm"><i class="tf-icons mdi mdi-trash-can"></i></a>';
                    $viewButton = '<a href="servants/' . $info->id . '" class="btn btn-outline-primary btn-sm"><i class="tf-icons mdi mdi-eye"></i></a>';
                    // Check user role before adding edit and delete buttons
                    if (Auth::user()->role_id == '1' || Auth::user()->role_id == '2') {
                        return '<div class="dropdow flex gap-2">'. $viewButton . $editButton . $deleteButton . '</div>';
                    } else {
                        // Default case for users with no edit/delete permissions
                        return '<div class="dropdown">' . $viewButton . '</div>';
                    }
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('servants.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('servants.create');
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
            'password' => 'required',
            'avatar' => 'nullable',
        ]);

        $data['status'] = 'Active';
        $data['password'] = bcrypt($request->input('password'));

        $servant = User::create(array_merge($data, ['section_id' => '4', 'role_id' => '7']))->assignRole('Member');

        if ($request->hasFile('avatar')) {
            $filename = 'avatars/' . time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $servant->avatar = $filename;
            $servant->save();
            $request->file('avatar')->move(public_path('avatars'), $filename);
        }

        // Notification

        $target = User::whereHas('roles', function ($query) {
            $query->whereIn('id', [1, 2]); // Use whereIn for multiple IDs
        })->get();

        Notification::send($target, new ServantsNotification($servant, 'New Servants Profile has been created!'));

        return redirect()->route('servants.edit', [
            'servant' => $servant->id,
        ])->with('success', 'Profile created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $servant = User::find($id);
        return view('servants.show', ['servant' => $servant]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $servant = User::find($id);
        return view('servants.edit', ['servant' => $servant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|regex:/^[A-Za-z\s\.\-]+$/',
            'email' => 'required',
            'username' => 'required',
            'contact_number' => 'required|regex:/^[0-9\s\-\+\(\)]+$/',
            'gender' => 'required',
            'area' => 'required',
            'chapter' => 'required',
            'avatar' => 'nullable',
        ]);

        $status = $request->has('status') ? 'Active' : 'Inactive';
        $data['status'] = $status;

        $servant = User::find($id);
        $servant->update($data);

        $oldAvatarPath = $servant->avatar; // Get the old avatar path before updating

        if ($request->hasFile('avatar')) {
            // Handle the new avatar upload as you've implemented
            $avatar = $request->file('avatar');
            $filename = 'avatars/' . time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('avatars'), $filename);

            // Update the newMember's avatar with the new file path
            $servant->avatar = $filename;
            $servant->save();

            // Delete the old avatar file if it exists
            if ($oldAvatarPath && file_exists(public_path($oldAvatarPath))) {
                unlink(public_path($oldAvatarPath));
            }
        }

        return redirect()->route('servants.edit', [
            'servant' => $servant->id,
        ])->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request, string $id)
    {
        try {
            // Validate input
            $data = $request->validate([
                'current_pass' => 'required',
                'new_pass' => 'required|min:8|different:current_pass',
                'confirm_pass' => 'required|same:new_pass',
            ]);

            // Check if the entered current password matches the user's actual password
            $servant = User::find($id);
            if (!Hash::check($request->input('current_pass'), $servant->password)) {
                return redirect()->back()->withErrors(['current_pass' => 'Credentials is incorrect.']);
            }

            // If the current password is correct, proceed to update the password
            $servant->password = bcrypt($request->input('new_pass'));
            $servant->user->password = bcrypt($request->input('new_pass'));

            $servant->update($data);

            return redirect()->back()
                ->with('success', 'Password updated successfully!');


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
