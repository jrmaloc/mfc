<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use App\Notifications\MemberNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    // /**
    //  * Handle an incoming registration request.
    //  *
    //  * @throws \Illuminate\Validation\ValidationException
    //  */
    public function store(Request $request): RedirectResponse
    {

        $data = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username', // Add table and column name
            'email' => 'required|email|unique:users,email', // Add table and column name
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['contact_number'] = $request->input('contact_number', null);
        $data['gender'] = $request->input('gender', null);
        $data['area'] = $request->input('area', null);
        $data['chapter'] = $request->input('chapter', null);

        $user = User::create($data)->assignRole('Member');
        $newMember = Member::create(array_merge($data, ['user_id' => $user->id]));

        $admins = User::whereHas('roles', function ($query) {
            $query->whereIn('id', [1, 2]); // Use whereIn for multiple IDs
        })->get();

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verify');
    }
}
