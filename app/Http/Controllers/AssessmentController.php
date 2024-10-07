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
        'type' => 'teacher-assign',
        'course_id' => $request->input('course_id'),
    ]);

    // Assign students to groups
    $groupSize = ceil($students->count() / $request->input('num_required_reviews'));
    $groups = array_chunk($students->toArray(), $groupSize);

    // Create groups
    foreach ($groups as $group) {
        $groupModel = Group::create([
            'assessment_id' => $assessment->id,
        ]);

        // Assign students to the group
        foreach ($group as $student) {
            GroupMember::create([
                'group_id' => $groupModel->id,
                'user_id' => $student['id'],
            ]);
        }
    }

    // Redirect to the assessments index
    return redirect()->route('assessments.index');
}

public function show(Assessment $assessment)
{
    // Get the course for the assessment
    $course = $assessment->course;

    // Get the students enrolled in the course
    $students = $course->students()->get();

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
    if (auth()->user()->isTeacher()) {
        // Display the teacher view
        return view('assessments.teacher', compact('assessment', 'course', 'students', 'groups', 'groupedStudents'));
    } else {
        // Display the student view
        return view('assessments.student', compact('assessment', 'course', 'students', 'groups', 'groupedStudents', 'reviews', 'numRequiredReviews', 'reviewees'));
    }
}


public function store(Request $request)
{
    $assessment = new Assessment();
    $assessment->course_id = $request->course_id;
    $assessment->title = $request->title;
    $assessment->instruction = $request->instruction;
    $assessment->num_required_reviews = $request->num_reviews;
    $assessment->max_score = $request->max_score;
    $assessment->due_date = $request->due_date;
    $assessment->type = $request->type;
    $assessment->save();
    return redirect()->back()->with('success', 'Assessment created successfully!');
}

}