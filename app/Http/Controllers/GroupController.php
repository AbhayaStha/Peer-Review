<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupMember;

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
        // Get the students in the group
        $students = $group->groupMembers()->get();
        
        // Get the ratings provided by each student
        $ratings = [];
        foreach ($students as $student) {
            $user = $student->user;
            $ratings[$student->id] = $user->reviewsGiven()->where('assessment_id', $group->assessment_id)->get();
        }
        
        // Return the view
        return view('group', compact('group', 'students', 'ratings'));
    }

    public function store(Request $request)
    {
        // Check if a group with the same name already exists
        $existingGroup = Group::where('assessment_id', $request->input('assessment_id'))
            ->where('group_name', $request->input('group_name'))
            ->first();
    
        if ($existingGroup) {
            // If a group with the same name already exists, use that one
            $group = $existingGroup;
        } else {
            // Create a new group
            $group = Group::create([
                'assessment_id' => $request->input('assessment_id'),
                'group_name' => $request->input('group_name'),
            ]);
        }
    
        // Add students to the group
        foreach ($request->input('students') as $studentId) {
            // Check if the student is already a member of a group
            $existingMember = GroupMember::where('user_id', $studentId)
                ->where('group_id', function ($query) use ($request) {
                    $query->where('assessment_id', $request->input('assessment_id'));
                })
                ->first();
    
            if (!$existingMember) {
                // If the student is not already a member of a group, add them
                GroupMember::create([
                    'group_id' => $group->id,
                    'user_id' => $studentId,
                ]);
            } else {
                // If the student is already a member of a group, remove them from the existing group
                GroupMember::where('user_id', $studentId)
                    ->where('group_id', function ($query) use ($request) {
                        $query->where('assessment_id', $request->input('assessment_id'));
                    })
                    ->delete();
    
                // Add the student to the new group
                GroupMember::create([
                    'group_id' => $group->id,
                    'user_id' => $studentId,
                ]);
            }
        }
    
        // Redirect to the assessment page
        return redirect()->route('assessments.show', $request->input('assessment_id'));
    }
}