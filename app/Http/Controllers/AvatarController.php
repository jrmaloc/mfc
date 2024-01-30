<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png|max:800',
        ]);

        $avatar = $request->file('avatar');
        $filename = time() . '.' . $avatar->getClientOriginalExtension();
        $avatar->move(public_path('avatars'), $filename);

        Avatar::create([
            'filename' => $filename,
        ]);

        return back()->with('success', 'Avatar uploaded successfully.');
    }
}
