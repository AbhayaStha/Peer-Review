<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Group Members: A user can be part of many groups
    public function groupMembers()
    {
        return $this->hasMany(GroupMember::class);
    }

    // Reviews: A user can write and receive many reviews
    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }
}
