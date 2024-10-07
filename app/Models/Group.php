<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'group_name',
    ];

    // Assessment: A group belongs to an assessment
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    // Group Members: A group can have many group members
    public function groupMembers()
    {
        return $this->hasMany(GroupMember::class);
    }
}
