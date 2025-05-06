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
        'password',
        'role', 
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
        ];
    }
/**
     * Get the teams led by the user.
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
        return $this->belongsToMany(Team::class)->withPivot('role')->withTimestamps();
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