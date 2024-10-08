<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_code',
        'name',
];
    
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Assessments: A course can have many assessments
    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    // Teachers: A course can have many teachers
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id')->wherePivot('role', 'teacher');
    }

    // Students: A course can have many students
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id')->wherePivot('role', 'student');
    }
}