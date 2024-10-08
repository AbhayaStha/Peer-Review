<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marking extends Model
{
    protected $fillable = [
        'assessment_id',
        'student_id',
        'mark',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class);
    }
}