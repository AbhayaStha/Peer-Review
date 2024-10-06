<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function create(Request $request)
    {
        // Validate the group form
        $request->validate([
            'assessment_id' => 'required',
            'group_name' => 'required',
        ]);

        // Create a new group
        Group::create([
            'assessment_id' => $request->input('assessment_id'),
            'group_name' => $request->input('group_name'),
        ]);

        // Redirect to the groups index
        return redirect()->route('groups.index');
    }

    public function show(Group $group)
    {
        // Display the group details
        return view('groups.show', compact('group'));
    }
}