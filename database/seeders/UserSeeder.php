<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => 'Teacher ' . $i,
                'email' => 'teacher' . $i . '@example.com',
                's_number' => 'T' . $i,
                'password' => bcrypt('password'),
                'type' => 'teacher',
            ]);
        }

        // Create 50 students
        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'name' => 'Student ' . $i,
                'email' => 'student' . $i . '@example.com',
                's_number' => 'S' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'password' => bcrypt('password'),
                'type' => 'student',
            ]);
        }
    }
}
