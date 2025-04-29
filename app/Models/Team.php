<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'competition_id',
        'leader_id',
    ];

    /**
     * Get the competition that the team is participating in.
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * Get the user who leads the team.
     */
    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    /**
     * Get all members of the team.
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'team_members')
            ->withPivot('status')
            ->withTimestamps();
    }

    /**
     * Get invitations sent for this team.
     */
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * Check if a user is a member of this team.
     */
    public function hasMember($userId)
    {
        return $this->members()
            ->wherePivot('user_id', $userId)
            ->wherePivot('status', 'accepted')
            ->exists();
    }

    /**
     * Get accepted members of the team.
     */
    public function acceptedMembers()
    {
        return $this->members()->wherePivot('status', 'accepted');
    }
}
