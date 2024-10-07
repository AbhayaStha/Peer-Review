<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Assessment;

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
        if (auth()->user()->isTeacher() && $course->teachers->contains(auth()->user())) {
            // Get the assessments for the course
            $assessments = $course->assessments;

            // Get the teachers for the course
            $teachers = $course->teachers;

            // Display the course details
            return view('course', compact('course', 'assessments', 'teachers'));
        } elseif (auth()->user()->isStudent() && $course->enrollments()->where('user_id', auth()->user()->id)->exists()) {
            // Get the assessments for the course
            $assessments = $course->assessments;
            $teachers = $course->teachers;

            // Display the course details
            return view('course', compact('course', 'assessments', 'teachers'));
        } else {
            // Return an error message
            return redirect()->route('dashboard')->with('error', 'You do not have access to this course.');
        }
    }
}
