<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        // Get all courses
        $courses = Course::all();

        // Display the courses
        return view('courses.index', compact('courses'));
    }

    public function create(Request $request)
    {
        // Validate the course form
        $request->validate([
            'code' => 'required',
            'name' => 'required',
        ]);

        // Create a new course
        Course::create([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
        ]);

        // Redirect to the courses index
        return redirect()->route('courses.index');
    }

    public function show(Course $course)
    {
        // Display the course details
        return view('courses.show', compact('course'));
    }
}