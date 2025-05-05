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
    /**
     * Get the competitions organized by the user.
     */
    public function organizedCompetitions()
    {
        return $this->hasMany(Competition::class, 'organizer_id');
    }
    
    /**
     * Get direct access to registrations table for category filter feature.
     */
    public function registrationRecords()
    {
        return \DB::table('registrations')->where('user_id', $this->id);
    }
    
    /**
     * Get the competitions the user is registered for.
     */
    public function registeredCompetitions()
    {
        return $this->belongsToMany(Competition::class, 'registrations');
    }
    
    /**
     * Get the competitions saved/bookmarked by the user.
     */
    public function savedCompetitions()
    {
        return $this->belongsToMany(Competition::class, 'saved_competitions', 'user_id', 'competition_id')
                    ->withTimestamps();
    }

    /**
     * Alternative relationship for competitions a user is part of (from main branch).
     */
    public function competitions()
    {
        return $this->belongsToMany(Competition::class, 'competition_user');
    }
    
    /**
     * Check if user is an admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    /**
     * Check if user is an organizer.
     */
    public function isOrganizer()
    {
        return $this->role === 'organizer';
    }
    
    /**
     * Check if user is a student/regular user.
     */
    public function isStudent()
    {
        return $this->role === 'user';
    }
    
    /**
     * Get assessment histories for this user.
     */
    public function assessmentHistories()
    {
        return $this->hasMany(\App\Models\AssessmentHistory::class);
    }

    /**
     * Get teams led by this user.
     */
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
}