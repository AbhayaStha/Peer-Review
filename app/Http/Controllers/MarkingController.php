<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marking;

class MarkingController extends Controller
{
    public function index(Request $request)
    {
        // Get all markings
        $markings = Marking::paginate(10);

        // Display the markings
        return view('markings.index', compact('markings'));
    }

    public function filter(Request $request)
    {
        // Filter the markings
        $markings = Marking::where('assessment_id', $request->input('assessment_id'))
            ->where('student_id', $request->input('student_id'))
            ->paginate(10);

        // Display the filtered markings
        return view('markings.index', compact('markings'));
    }
}