<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Assessment;
use App\Models\User;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // Validate the review form
        $request->validate([
            'assessment_id' => 'required',
            'reviewee_id' => 'required',
            'review_text' => 'required',
        ]);
    
        // Get the assessment and student
        $assessment = Assessment::find($request->input('assessment_id'));
        $student = auth()->user();
        $reviewee = User::find($request->input('reviewee_id'));
    
        // Check if the student is trying to review themselves
        if ($student->id === $reviewee->id) {
            return redirect()->back()->with('error', 'You cannot review yourself.');
        }
    
        // Check if the student has already submitted a review for the reviewee
        $existingReview = Review::where('assessment_id', $assessment->id)
            ->where('reviewer_id', $student->id)
            ->where('reviewee_id', $reviewee->id)
            ->first();
    
        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already submitted a review for this student.');
        }
    
        // Check if the student has exceeded the required number of reviews
        $requiredReviews = $assessment->num_required_reviews;
        $submittedReviews = Review::where('assessment_id', $assessment->id)
            ->where('reviewer_id', $student->id)
            ->count();
    
        if ($submittedReviews >= $requiredReviews) {
            return redirect()->back()->with('error', 'You have already submitted the required number of reviews.');
        }
    
        // Create a new review
        Review::create([
            'assessment_id' => $request->input('assessment_id'),
            'reviewer_id' => auth()->user()->id,
            'reviewee_id' => $request->input('reviewee_id'),
            'review_text' => $request->input('review_text'),
            'submitted_at' => now(),
        ]);
    
        // Redirect to the assessment page
        return redirect()->route('assessments.show', $request->input('assessment_id'))->with('success', 'Review submitted successfully!');
    }

    public function show(User $user)
    {
        // Get the reviews given by the user
        $reviewsGiven = $user->reviewsGiven;
    
        // Get the reviews received by the user
        $reviewsReceived = $user->reviewsReceived;
    
        // Return the view
        return view('review', compact('user', 'reviewsGiven', 'reviewsReceived'));
    }
}