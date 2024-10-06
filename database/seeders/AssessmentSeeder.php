<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Assessment;
use App\Models\Course;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            Assessment::create([
                'course_id' => $course->id,
                'title' => 'Assessment ' . $course->id,
                'instruction' => 'This is assessment ' . $course->id,
                'num_required_reviews' => 2,
                'max_score' => 100,
                'due_date' => now()->addDays(7),
                'type' => 'teacher-assign',
            ]);
        }

    }
}
