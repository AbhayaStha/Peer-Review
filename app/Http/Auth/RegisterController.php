<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Validate the registration form
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            's_number' => 'required|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        // Create a new user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            's_number' => $request->input('s_number'),
            'password' => bcrypt($request->input('password')),
            'type' => 'student',
        ]);

        // Login the user
        auth()->login($user);

        // Redirect to the dashboard
        return redirect()->route('dashboard');
    }
}