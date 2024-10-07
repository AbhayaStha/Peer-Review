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
        // dd($request->all());
        // Validate the review form
        $request->validate([
            'assessment_id' => 'required',
            'reviewee_id' => 'required',
            'review_text' => 'required',
        ]);
    
        // Create a new review
        Review::create([
            'assessment_id' => $request->input('assessment_id'),
            'reviewer_id' => auth()->user()->id,
            'reviewee_id' => $request->input('reviewee_id'),
            'review_text' => $request->input('review_text'),
            'submitted_at' => now(),
        ]);
    
        // Redirect to the assessment page
        return redirect()->route('assessments.show', $request->input('assessment_id'));
    }

    public function show(User $user)
    {
        // Get the reviews for the user
        $reviews = $user->reviews;

        // Get the reviews received by the user
        $reviewsReceived = $user->reviewsReceived;

        // Display the reviews
        return view('reviews.show', compact('user', 'reviews', 'reviewsReceived'));
    }
}