<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Check user role and direct to appropriate dashboard
        if ($user->type === 'student') {
            return view('dashboard.student', ['user' => $user]);
        } elseif ($user->type === 'teacher') {
            return view('dashboard.teacher', ['user' => $user]);
        } else {
            // Handle any other user types or show a generic dashboard
            return view('dashboard.generic', ['user' => $user]);
        }
    }
}
