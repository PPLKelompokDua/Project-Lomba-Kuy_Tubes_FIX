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
     * Get the competitions organized by the user.
     */
    public function organizedCompetitions()
    {
        return $this->hasMany(Competition::class, 'organizer_id');
    }
    
    /**
     * Get the registrations made by the user.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
    
    /**
     * Get the competitions the user is registered for.
     */
    public function registeredCompetitions()
    {
        return $this->belongsToMany(Competition::class, 'registrations');
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
}