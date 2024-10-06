<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;

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
        ]);

        // Redirect to the assessments index
        return redirect()->route('assessments.index');
    }

    public function show(Assessment $assessment)
    {
        // Display the assessment details
        // return view('assessments.show', compact(' assessment'));
    }
}