<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Assessment;
use App\Models\User;
use App\Http\Controllers\EnrollmentController;

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
            'code' => 'required|string',
            'name' => 'required|string'
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

    public function enrollStudents(Course $course)
    {
        $enrolledStudentIds = $course->enrollments()->pluck('user_id')->toArray();
        $availableStudents = User::where('type', 'student')->whereNotIn('id', $enrolledStudentIds)->get();
        return view('enrol', compact('course', 'availableStudents'));
    }

    public function enrollStudentsStore(Request $request, Course $course)
    {
        $request->merge(['course_id' => $course->id, 'type' => 'enroll']);
        $enrollmentController = new EnrollmentController();
        return $enrollmentController->storeMultipleStudents($request, 'enroll');
    }
}