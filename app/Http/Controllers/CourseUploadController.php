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
            'file' => 'required|mimes:csv,txt',
        ], [
            'file.mimes' => 'The file must be a CSV or TXT file.',
        ]);

        try {
            // Read the uploaded file
            $file = $request->file('file');
            $contents = file($file->getRealPath());

            // Parse the CSV data
            $data = array_map('str_getcsv', $contents);

            // Skip the header row
            array_shift($data);

            // Get the course data
            $courseData = $data[0];

            // Get the course code and name
            $courseCode = $courseData[0];
            $courseName = $courseData[1];

            // Check if a course with the same code already exists
            if (Course::where('code', $courseCode)->exists()) {
                return redirect()->back()->with('error', 'A course with the same code already exists.');
            }

            // Create a new course
            $course = Course::create([
                'course_code' => $courseCode,
                'name' => $courseName,
            ]);

            // Redirect to the courses index
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while uploading the course.');

        }
    }
}