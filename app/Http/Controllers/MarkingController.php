<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marking;
use App\Models\Assessment;
use App\Models\User;

class MarkingController extends Controller
{
    public function store(Request $request)
    {
        // Validate the mark form
        $request->validate([
            'assessment_id' => 'required',
            'student_id' => 'required',
            'mark' => 'required|numeric|max:' . Assessment::find($request->input('assessment_id'))->max_score,
        ]);

        // Get the assessment and student
        $assessment = Assessment::find($request->input('assessment_id'));
        $student = User::find($request->input('student_id'));

        // Create a new marking
        Marking::create([
            'assessment_id' => $assessment->id,
            'student_id' => $student->id,
            'mark' => $request->input('mark'),
        ]);

        // Redirect to the assessment page
        return redirect()->route('reviews.show', $student)->with('success', 'Score assigned successfully!');
    }
}