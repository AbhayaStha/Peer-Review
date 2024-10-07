<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // For authentication
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        's_number',
        'password',
        'type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Courses where the user is a student
    public function studentCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')->wherePivot('role', 'student');
    }

    // Courses where the user is a teacher
    public function teacherCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')->wherePivot('role', 'teacher');
    }

    public function groupMembers()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    /**
     * Helper functions
     */
    public function isStudent()
    {
        return $this->type === 'student';
    }

    public function isTeacher()
    {
        return $this->type === 'teacher';
    }
}
