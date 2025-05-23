<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'team_id',
        'assigned_user_id',
        'title',
        'description',
        'due_date',
        'status',
        'completed_at',
        'blocked_at',
        'blocker_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
    
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
    
}
