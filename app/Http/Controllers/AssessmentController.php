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
        'title' => 'required|string|max:20',
        'instruction' => 'required|string',
        'num_required_reviews' => 'required|integer|min:1',
        'max_score' => 'required|integer|min:1|max:100',
        'due_date' => 'required|date',
        'type' => 'required|string',
        'course_id' => 'required|exists:courses,id',
    ]);

    // Get the course and students
    $course = Course::find($request->input('course_id'));
    $students = $course->students()->get();

    // Create a new assessment
    $assessment = Assessment::create([
        'title' => $request->input('title'),
        'instruction' => $request->input('instruction'),
        'num_required_reviews' => $request->input('num_required_reviews'),
        'max_score' => $request->input('max_score'),
        'due_date' => $request->input('due_date'),
        'type' => $request->input('type'),
        'course_id' => $request->input('course_id'),
    ]);

}


public function show(Assessment $assessment)
{
    // Get the course for the assessment
    $course = $assessment->course;

    // Get the students enrolled in the course
    $allStudents = $course->students()->get();

    // Get the students enrolled in the course for student reviews
    $studentsForReviews = $course->students()->where('type', '!=', 'teacher')->paginate(10);

    // Get the groups for the assessment
    $groups = $assessment->groups;

    // Get the students for each group
    $groupedStudents = [];
    foreach ($groups as $group) {
        $groupedStudents[$group->id] = $group->groupMembers()->get();
    }

    // Get the peer reviews received by the student
    $reviews = $assessment->reviews()->where('reviewee_id', auth()->id())->get();

    // Get the number of required reviews
    $numRequiredReviews = $assessment->num_required_reviews;

    // Get the group of the current user
    $currentUserGroup = $groups->first(function ($group) {
        return $group->groupMembers()->where('user_id', auth()->id())->exists();
    });

    // Get the reviewees for the student
    $reviewees = [];
    if ($currentUserGroup) {
        $reviewees = $currentUserGroup->groupMembers()->where('user_id', '!=', auth()->id())->get();
    }
    // Check if the user is a teacher
    if (auth()->user()->type === 'teacher') {
        // Display the teacher view
        return view('assessments.teacher', compact('assessment', 'course', 'allStudents', 'groups', 'groupedStudents', 'numRequiredReviews', 'studentsForReviews'));
    } else {
        // Display the student view
        return view('assessments.student', compact('assessment', 'course', 'studentsForReviews', 'groups', 'groupedStudents', 'reviews', 'numRequiredReviews', 'reviewees'));
    }

}
    public function hasSubmission()
    {
        return $this->reviews()->exists();
    }

    public function edit(Assessment $assessment)
    {
    return view('assessments.edit', compact('assessment'));
    }

    public function update(Request $request, Assessment $assessment)
{
    // Validate the assessment form
    $request->validate([
        'title' => 'required|string|max:20',
        'instruction' => 'required|string',
        'num_required_reviews' => 'required|integer|min:1',
        'max_score' => 'required|integer|min:1|max:100',
        'due_date' => 'required|date',
    ]);

    // Update the assessment
    $assessment->update([
        'title' => $request->input('title'),
        'instruction' => $request->input('instruction'),
        'num_required_reviews' => $request->input('num_required_reviews'),
        'max_score' => $request->input('max_score'),
        'due_date' => $request->input('due_date'),
    ]);

    // Redirect to the assessments index
    return redirect()->route('assessments.show', $assessment)->with('success', 'Assessment updated successfully!');
}

public function store(Request $request)
{
    // Validate the assessment form
    $request->validate([
        'course_id' => 'required|exists:courses,id',
        'title' => 'required|string|max:20',
        'instruction' => 'required|string',
        'num_required_reviews' => 'required|integer|min:1',
        'max_score' => 'required|integer|min:1|max:100',
        'due_date' => 'required|date',
        'type' => 'required|string',
    ]);

    $assessment = new Assessment();
    $assessment->course_id = $request->course_id;
    $assessment->title = $request->title;
    $assessment->instruction = $request->instruction;
    $assessment->num_required_reviews = $request->num_required_reviews;
    $assessment->max_score = $request->max_score;
    $assessment->due_date = $request->due_date;
    $assessment->type = $request->type;
    $assessment->save();
    return redirect()->back()->with('success', 'Assessment created successfully!');
}
}