<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            Review::create([
                'assessment_id' => rand(1, 5),
                'reviewer_id' => rand(6, 55), // 6 to 55 because we created 5 teachers and 50 students
                'reviewee_id' => rand(6, 55), 
                'review_text' => 'This is a review',
                'submitted_at' => now(),
            ]);
        }
    }
}
