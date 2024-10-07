<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Enrollment;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            $courseId = ($i % 5) + 1;
            Enrollment::create([
                'course_id' => $courseId,
                'user_id' => $i + 5, 
            ]);
        }
    }
}