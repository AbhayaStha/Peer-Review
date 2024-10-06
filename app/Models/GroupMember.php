<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    use HasFactory;

    use HasFactory;

    // Group: A group member belongs to a group
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    // User: A group member belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
