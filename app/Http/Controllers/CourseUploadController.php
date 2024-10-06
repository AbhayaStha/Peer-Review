<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:txt',
        ]);

        // Read the uploaded file
        $file = $request->file('file');
        $contents = file_get_contents($file->getPathname());

        // Parse the file contents
        $courseData = explode("\n", $contents);
        $courseCode = trim($courseData[0]);
        $courseName = trim($courseData[1]);
        $teachers = explode(',', trim($courseData[2]));
        $assessments = explode(',', trim($courseData[3]));
        $students = explode(',', trim($courseData[4]));

        // Create a new course
        $course = Course::create([
            'code' => $courseCode,
            'name' => $courseName,
        ]);

        // Add teachers to the course
        foreach ($teachers as $teacher) {
            $course->teachers()->attach($teacher);
        }

        // Add assessments to the course
        foreach ($assessments as $assessment) {
            $course->assessments()->attach($assessment);
        }

        // Add students to the course
        foreach ($students as $student) {
            $course->students()->attach($student);
        }

        // Redirect to the courses index
        return redirect()->route('courses.index');
    }
}