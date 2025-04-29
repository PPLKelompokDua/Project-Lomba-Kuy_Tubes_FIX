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
        ];
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
}