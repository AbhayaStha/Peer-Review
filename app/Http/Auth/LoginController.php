<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate the login credentials
        $request->validate([
            's_number' => 'required',
            'password' => 'required',
        ]);

        // Attempt to login the user
        if (!auth()->attempt(['s_number' => $request->input('s_number'), 'password' => $request->input('password')])) {
            return redirect()->back()->withErrors(['Invalid credentials']);
        }

        // Redirect to the dashboard
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('login');
    }
}

