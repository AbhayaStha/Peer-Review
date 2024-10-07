<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'title',
        'instruction',
        'num_reviews',
        'max_score',
        'due_date',
        'type',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Groups: An assessment can have many groups
    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    // Reviews: An assessment can have many reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
