<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Sections;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show()
    {
        $user = Auth::user();

        return view('profile.show', [
            'user' => $user,
        ]);
    }

    public function edit(Request $request): View
    {
        $sections = Sections::all();

        $user = Auth::user();
        $role_id = $user->role_id;
        $role = Role::findOrFail($role_id);

        return view('profile.edit', [
            'user' => $request->user(),
            'sections' => $sections,
            'role' => $role,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|regex:/^[A-Za-z\s\.\-]+$/',
            'username' => 'required|alpha_dash:ascii',
            'gender' => 'required',
            'area' => 'required',
            'chapter' => 'required',
            'section' => 'required',
            'contact_number' => 'required|regex:/^[0-9\s-]+$/',
            'email' => 'required|email',
            'current_password' => 'required|string|min:8',
            'avatar' => 'nullable',
        ], [
            'contact_number.regex' => 'contact number must consist of numbers only',
            'current_password.required' => 'please confirm your password.',
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            // If the entered current password doesn't match, add an error message and redirect back
            return back()->withErrors(['current_password' => 'Incorrect Credentials'])->withInput();
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $status = $request->has('status') ? 'Active' : 'Inactive';
        $section = $request->section;

        $data['current_password'] = bcrypt($data['current_password']);
        $data['status'] = $status;

        $user->update($data);
        $user->section_id = $section;

        $oldAvatarPath = $user->avatar; // Get the old avatar path before updating

        if ($request->hasFile('avatar')) {
            // Handle the new avatar upload as you've implemented
            $avatar = $request->file('avatar');
            $filename = 'avatars/' . time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('avatars'), $filename);

            // Update the user's avatar with the new file path
            $user->avatar = $filename;

            // Delete the old avatar file if it exists
            if ($oldAvatarPath && file_exists(public_path($oldAvatarPath))) {
                unlink(public_path($oldAvatarPath));
            }
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'Profile Updated');
    }

    public function updatePassword(Request $request, User $user)
    {
        $data = $request->validate([
            'current_pass' => 'required',
            'new_pass' => 'required|min:8|different:current_pass',
            'confirm_pass' => 'required|same:new_pass',
        ], [
            'new_pass.required' => 'New password is required',
            'new_pass.min' => 'New password must be at least 8 characters',
            'new_pass.different' => 'New password must be different from the current password',
            'current_pass.required' => 'Current password is required',
            'confirm_pass.required' => 'Confirm password is required',
            'confirm_pass.same' => 'Passwords doesn\'t match',
        ]);

        // Check if the entered current password matches the user's actual password
        if (!Hash::check($request->input('current_pass'), $user->password)) {
            Session::flash('error', 'Credentials are incorrect.');
            return redirect()->back();
        }

        // If the current password is correct, proceed to update the password
        $user->password = bcrypt($request->input('new_pass'));
        $user->household_servant->password = bcrypt($request->input('new_pass'));

        $user->update($data);
        $user->household_servant->update($data);

        return redirect()->back()
            ->with('success', 'Password updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse//Logout
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
