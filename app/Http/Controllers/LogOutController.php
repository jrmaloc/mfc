<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogOutController extends Controller
{
    public function logout()
    {
        Auth::logout(); // Logs the user out

        return redirect('/'); // Redirect to your desired page after logout
    }
}
