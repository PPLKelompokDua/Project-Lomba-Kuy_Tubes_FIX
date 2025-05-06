<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'profile_image',
        'password',
        'role', 
        'notification_preferences',
        'personality_type',
        'preferred_role',
        'experience',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'notification_preferences' => 'array',
            'experience' => 'array',
        ];
    }

    public function registrationRecords()
    {
        return \DB::table('registrations')->where('user_id', $this->id);
    }

    public function savedCompetitions()
    {
        return $this->belongsToMany(Competition::class, 'saved_competitions', 'user_id', 'competition_id')
                    ->withTimestamps();
    }

    public function competitions()
    {
        return $this->belongsToMany(Competition::class, 'competition_user');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isOrganizer()
    {
        return $this->role === 'organizer';
    }

    public function isStudent()
    {
        return $this->role === 'user';
    }
    
    public function assessmentHistories()
    {
        return $this->hasMany(\App\Models\AssessmentHistory::class);
    }

    public function ledTeams()
    {
        return $this->hasMany(Team::class, 'leader_id');
    }

    /**
     * Get all teams the user is a member of.
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_members')
            ->withPivot('status')
            ->withTimestamps();
    }
    

    /**
     * Get invitations sent by the user.
     */
    public function sentInvitations()
    {
        return $this->hasMany(Invitation::class, 'sender_id');
    }

    /**
     * Get invitations received by the user.
     */
    public function receivedInvitations()
    {
        return $this->hasMany(Invitation::class, 'receiver_id');
    }

    /**
     * Get messages sent by the user.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get messages received by the user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get forum posts created by the user.
     */
    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class);
    }

    public function memberTeams()
    {
        return $this->belongsToMany(Team::class, 'team_members')
                    ->wherePivot('status', 'accepted');
    }
}