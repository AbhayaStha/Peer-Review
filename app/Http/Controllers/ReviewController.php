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
            'reviewee_id' => 'required',
            'review_text' => 'required',
        ]);

        // Create a new review
        Review::create([
            'reviewer_id' => auth()->user()->id,
            'reviewee_id' => $request->input('reviewee_id'),
            'review_text' => $request->input('review'),
            'assessment_id' => $request->input('assessment_id'),
        ]);

        // Redirect to the assessments index
        return redirect()->route('assessments.index');
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