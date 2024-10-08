<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Assessment;
use App\Models\User;

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
    

            $data = array_map('str_getcsv', $contents);
    
            // Skip the header row
            array_shift($data);
    
            $courseData = $data[0];
    
            $courseCode = $courseData[0];
            $courseName = $courseData[1];
            $teachers = explode(',', $courseData[2]);
            $assessments = explode(',', $courseData[3]);
            $students = explode(',', $courseData[4]);
            $snumberTeachers = explode(',', $courseData[5]);
            $snumberStudents = explode(',', $courseData[6]);
    
            // Dump the data from the CSV file
            dd([
                'course_code' => $courseCode,
                'course_name' => $courseName,
                'teachers' => $teachers,
                'assessments' => $assessments,
                'students' => $students,
                'snumber_teachers' => $snumberTeachers,
                'snumber_students' => $snumberStudents,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while uploading the course.');
        }
    }
    
}