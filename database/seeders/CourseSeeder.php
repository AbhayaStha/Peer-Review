<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            ['course_code' => 'MATH001', 'name' => 'Mathematics'],
            ['course_code' => 'SCIE002', 'name' => 'Science'],
            ['course_code' => 'ENGL003', 'name' => 'English'],
            ['course_code' => 'HIST004', 'name' => 'History'],
            ['course_code' => 'PHYS005', 'name' => 'Physics'],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}