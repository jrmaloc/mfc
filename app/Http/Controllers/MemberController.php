<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Notifications\MemberNotification;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class MemberController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view-member|create-member|edit-member|delete-member', ['only' => ['index', 'store', 'create', 'update', 'edit', 'destroy', 'show']]);
        $this->middleware('permission:create-member', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-member', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-member', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Member::get();

            return DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('household_servant', '{{$household_servant_name}}')
                ->addColumn("actions", function ($member) {
                    return '<div class="dropdown">
                    <a href="show/' . $member->id . '" class="btn btn-outline-primary btn-sm"><i class="tf-icons mdi mdi-eye"></i></a>
                    <a href="edit/' . $member->id . '" class="btn btn-outline-info btn-sm"><i class="tf-icons mdi mdi-pencil"></i></a>
                    <a href="javascript:void(0);" id="' . $member->id . '" class="btn btn-outline-danger remove-btn btn-sm"><i class="tf-icons mdi mdi-trash-can"></i></a>
                    </div>';
                })

                ->rawColumns(['actions'])

                ->make(true);
        }
        $user = Auth::user();
        $userID = $user->id;

        return view('directory.members.list-member', ['members' => Member::with('household_servant')->get()], [
            'user' => $user,
            'id' => $userID,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('directory.members.create-member');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|regex:/^[A-Za-z\s\.\-]+$/',
            'username' => 'required|alpha_dash:ascii',
            'email' => 'required|email',
            'contact_number' => 'required|regex:/^[0-9\s\-\+\(\)]+$/',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'avatar' => 'nullable',
        ]);
        
        // Check if the checkbox is checked
        $status = $request->has('status') ? 'Active' : 'Inactive';

        $data['password'] = bcrypt($data['password']);
        $data['contact_number'] = $request->input('contact_number', null);
        $data['gender'] = $request->input('gender', null);
        $data['area'] = $request->input('area', null);
        $data['chapter'] = $request->input('chapter', null);
        $data['status'] = $status;

        // Uncomment the following lines to create the member
        $user = User::create($data)->assignRole('Member');
        $newMember = Member::create(array_merge($data, ['user_id' => $user->id]));

        $filename = '';

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = 'avatars/' . time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('avatars'), $filename);

            // Now, you can use $filename as the path to store in the database or perform any further operations
            // For example:
            $newMember->avatar = $filename;
            $newMember->save();
        }

    


        $admins = User::whereHas('roles', function ($query) {
            $query->whereIn('id', [1, 2]); // Use whereIn for multiple IDs
        })->get();

        

        return redirect()->route('members.edit', [
            'member' => $newMember->id,
        ])->with('success', 'Member created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $user = Auth::user();
        $userID = $user->id;
        $notifications = Auth::user()->notifications;
        return view('directory.members.show-member', [
            'member' => $member,
            'user' => $user,
            'id' => $userID,
            'notifications' => $notifications,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        $user = Auth::user();
        $userID = $user->id;
        $notifications = Auth::user()->notifications;

        return view('directory.members.edit-member', [
            'member' => $member,
            'user' => $user,
            'id' => $userID,
            'notifications' => $notifications
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Member $member, Request $request)
    {
        $data = $request->validate([
            // Validation rules...
            'name' => 'required|regex:/^[A-Za-z\s\.\-]+$/',
            'username' => 'required|string',
            'gender' => 'required',
            'area' => 'required',
            'chapter' => 'required',
            'contact_number' => 'regex:/^[0-9\s\-\(\)\+]+$/',
            'email' => 'required|email',
            'avatar' => 'nullable',
        ], [
            'contact_number.min' => 'Invalid Phone Number',
            'contact_number.max' => 'Invalid Phone Number',
            'email.email' => 'Please provide a valid Email',
        ]);

        //If 'status' is not provided in the form, set a default value
        $status = $request->has('status') ? 'Active' : 'Inactive';
        $data['status'] = $status;


        $member->update($data);
        $member->user->update($data);

        $oldAvatarPath = $member->avatar; // Get the old avatar path before updating

        if ($request->hasFile('avatar')) {
            // Handle the new avatar upload as you've implemented
            $avatar = $request->file('avatar');
            $filename = 'avatars/' . time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('avatars'), $filename);

            // Update the newMember's avatar with the new file path
            $member->avatar = $filename;
            $member->save();

            // Delete the old avatar file if it exists
            if ($oldAvatarPath && file_exists(public_path($oldAvatarPath))) {
                unlink(public_path($oldAvatarPath));
            }
        }

        // Assuming the update was successful, set the 'success' session variable
        return redirect(route('members.edit', ['member' => $member]))->with('success', 'Profile Updated Successfully');
    }

    public function updatePassword(Request $request, Member $member)
    {
        // Validate input
        $data = $request->validate([
            'current_pass' => 'required',
            'new_pass' => 'required|min:8|different:current_pass',
            'confirm_pass' => 'required|same:new_pass',
        ], [
            'current_pass.required' => 'Please provide your current password',
            'new_pass.required' => 'New password is empty',
            'new_pass.min' => 'Password must be at least 8 characters',
            'new_pass.different' => 'Password must be different from the current one',
            'confirm_pass.required' => 'Confirm your new password',
            'confirm_pass.same' => 'Passwords do not match',
        ]);

        // Check if the entered current password matches the user's actual password
        if (!Hash::check($request->input('current_pass'), $member->password)) {
            Session::flash('error', 'Incorrect credentials. Please try again.');
            return redirect()->back();
        }

        // If the current password is correct, proceed to update the password
        $member->password = bcrypt($request->input('new_pass'));

        $member->update($data);

        return redirect()->back()
            ->with('success', 'Password updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $member = Member::findOrFail($request->id);
        $remove = $member->delete();
        $member->user->delete();

        if ($remove) {
            return response([
                'status' => true,
                'message' => 'Member Deleted Successfully'
            ]);
        }
    }
}
