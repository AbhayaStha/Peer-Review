<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Display the login form.
     */
    public function loginForm()
    {
        return view('login'); // return the view for the login form
    }

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        // Validate input fields
        $request->validate([
            's_number' => 'required|string', // Validate the student/teacher number
            'password' => 'required|string',
        ]);

        // Attempt to log in using the s_number and password
        if (Auth::attempt(['s_number' => $request->s_number, 'password' => $request->password])) {
            // If successful, redirect based on user type (or default route)
            $user = Auth::user();
            if ($user->type == 'teacher') {
                return redirect()->route('dashboard.teacher'); // example teacher dashboard
            } elseif ($user->type == 'student') {
                return redirect()->route('dashboard.student'); // example student dashboard
            }
        }

        // If authentication fails, redirect back to login with an error message
        return back()->withErrors([
            's_number' => 'Invalid credentials. Please try again.',
        ])->onlyInput('s_number');
    }

    /**
     * Log out the user and redirect to login.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

