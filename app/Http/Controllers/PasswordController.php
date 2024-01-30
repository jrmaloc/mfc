<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        // Validate input
        $request->validate([
            'current_pass' => 'required',
            'new_pass' => 'required|min:8|different:current_pass',
            'confirm_pass' => 'required|same:new_pass',
        ]);

        // Check if the entered current password matches the user's actual password
        if (!Hash::check($request->input('current_pass'), $user->password)) {
            return redirect()->back()->withErrors(['current_pass' => 'The current password is incorrect.']);
        }

        // If the current password is correct, proceed to update the password
        $user->password = bcrypt($request->input('new_pass'));
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully!');
    }
}
