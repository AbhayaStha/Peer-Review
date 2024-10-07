<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Course;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $type)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
        ]);
    
        // Check if we are enrolling a student
        if ($type == 'enroll') {
            // Enroll the student in the course
            $enrollment = Enrollment::firstOrNew([
                'course_id' => $request->input('course_id'),
                'user_id' => $request->input('user_id'),
                'role' => 'student',  
            ]);
    
            if ($enrollment->exists) {
                return redirect()->back()->with('error', 'You are already enrolled in this course.');
            }
    
            $enrollment->save();
    
            return redirect()->route('dashboard')->with('success', 'You have been enrolled in the course.');
        
        // Check if we are assigning a teacher
        } elseif ($type == 'teach') {
            // Assign the teacher to the course
            $enrollment = Enrollment::firstOrNew([
                'course_id' => $request->input('course_id'),
                'user_id' => $request->input('user_id'),
                'role' => 'teacher',  
            ]);
    
            if ($enrollment->exists) {
                return redirect()->back()->with('error', 'You are already teaching this course.');
            }
    
            $enrollment->save();
    
            return redirect()->route('dashboard')->with('success', 'You are now teaching this course.');
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        if (auth()->user()->isTeacher() && $course->teachers()->where('user_id', auth()->user()->id)->exists()) {
            // Return the course view
            return view('courses.show', compact('course'));
        } elseif (auth()->user()->isStudent() && $course->enrollments()->where('user_id', auth()->user()->id)->exists()) {
            // Return the course view
            return view('courses.show', compact('course'));
        } else {
            // Return an error message
            return redirect()->route('dashboard')->with('error', 'You do not have access to this course.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
