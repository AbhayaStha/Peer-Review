<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Assessment: A review belongs to an assessment
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    // Reviewer: A review is written by a user (reviewer)
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    // Reviewee: A review is about a user (reviewee)
    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }
}
