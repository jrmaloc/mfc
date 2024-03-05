<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Registration;
use App\Models\Tithe;
use App\Models\User;
use Carbon\Carbon;
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
        $id = $user->id;

        $profile = User::findOrFail($id);

        $dateOfBirth = $profile->birthday;
        $years = Carbon::parse($dateOfBirth)->age;

        $role_id = $profile->role_id;
        $role = Role::find($role_id);

        $tithes = Tithe::where('user_id', $id)->count();
        $events = Registration::where('user_id', $id)->count();

        return view('profile.show', [
            'id' => $id,
            'profile' => $profile,
            'age' => $years,
            'role' => $role,
            'events' => $events,
            'tithes' => $tithes,
        ]);
    }

    public function edit(Request $request): View
    {
        $user = Auth::user();
        $id = $user->id;

        $profile = User::findOrFail($id);

        $dateOfBirth = $profile->birthday;
        $years = Carbon::parse($dateOfBirth)->age;

        $role_id = $profile->role_id;
        $role = Role::find($role_id);

        $tithes = Tithe::where('user_id', $id)->count();
        $events = Registration::where('user_id', $id)->count();

        return view('profile.edit', [
            'id' => $id,
            'profile' => $profile,
            'age' => $years,
            'role' => $role,
            'events' => $events,
            'tithes' => $tithes,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, User $user): RedirectResponse
    {
        $id = $user->id;
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

            $profile = User::findOrFail($id);
            $update = $profile->update($data);

            $oldAvatarPath = $profile->avatar;

            if ($request->hasFile('avatar')) {
                // Handle the new avatar upload as you've implemented
                $avatar = $request->file('avatar');
                $filename = 'avatars/' . time() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('avatars'), $filename);

                // Update the newMember's avatar with the new file path
                $profile->avatar = $filename;
                $profile->save();

                // Delete the old avatar file if it exists
                if ($oldAvatarPath && file_exists(public_path($oldAvatarPath))) {
                    unlink(public_path($oldAvatarPath));
                }
            }

            if ($update) {
                return response()->json(['message' => 'Updated Successfully', 'data' => $data], 200);
            } else {
                return response()->json(['message' => 'Update Failed'], 404);
            }

        } else {
            abort(404);
        }
    }

    public function updatePassword(Request $request, User $user)
    {
        $id = $user->id;
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
            $profile = User::find($id);

            if (!Hash::check($request->input('current_password'), $profile->password)) {
                return response()->json(['message' => "Current Password doesn't match in our records."], 500);
            }

            // If the current password is correct, proceed to update the password
            $profile->password = bcrypt($request->input('new_password'));
            $profile->save();

            return response()->json([
                'message' => 'Password Updated Successfully',
            ], 200);
        } else {
            abort(404);
        }
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
