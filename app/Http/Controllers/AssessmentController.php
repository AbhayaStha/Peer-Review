<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Course;
use App\Models\User;

class AssessmentController extends Controller
{
    public function create(Request $request)
    {
        // Validate the assessment form
        $request->validate([
            'title' => 'required',
            'instruction' => 'required',
            'num_required_reviews' => 'required',
            'max_score' => 'required',
            'due_date' => 'required',
            'type' => 'required',
        ]);

        // Create a new assessment
        Assessment::create([
            'title' => $request->input('title'),
            'instruction' => $request->input('instruction'),
            'num_required_reviews' => $request->input('num_required_reviews'),
            'max_score' => $request->input('max_score'),
            'due_date' => $request->input('due_date'),
            'type' => $request->input('type'),
            'course_id' => $request->input('course_id'),
        ]);

        // Redirect to the assessments index
        return redirect()->route('assessments.index');
    }

    public function show(Assessment $assessment)
{
    // Get the course for the assessment
    $course = $assessment->course;

    // Get the students for the course
    $students = $course->students()->get();

    // Get the reviews for the assessment
    $reviews = $assessment->reviews;

    // Check if the user is a teacher
    if (auth()->user()->isTeacher()) {
        // Display the teacher view
        return view('assessments.teacher', compact('assessment', 'course', 'students', 'reviews'));
    } else {
        // Display the student view
        return view('assessments.student', compact('assessment', 'course', 'students', 'reviews'));
    }
}
}