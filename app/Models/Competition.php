<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'prize',
        'deadline',
        'registration_link',
        'external_registration_link',
        'location',
        'start_date',
        'end_date',
        'max_participants',
        'photo',
        'organizer_id',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'registration_deadline' => 'datetime',
    ];


    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
    
    public function participants()
    {
        return $this->belongsToMany(User::class, 'competition_user');
    }

    public function registeredParticipants()
    {
        return $this->belongsToMany(User::class, 'registrations');
    }


    public function savedBy()
    {
        return $this->belongsToMany(User::class, 'saved_competitions')
                    ->withTimestamps();
    }

    public function getStatusAttribute()
    {
        return \Carbon\Carbon::parse($this->deadline)->isFuture() ? 'open' : 'closed';
    }
    
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(\App\Models\User::class, 'saved_competitions', 'competition_id', 'user_id');
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }
}