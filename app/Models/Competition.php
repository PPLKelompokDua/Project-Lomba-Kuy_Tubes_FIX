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
        'registration_link',
        'external_registration_link',
        'location',
        'start_date',
        'end_date',
        'max_participants',
        'photo',
        'organizer_id',
        'status',
        'image',
        'registration_deadline'
    ];

    protected $casts = [
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
    
    /**
     * Alternative relationship using registrations table for category filter feature
     */
    public function registeredParticipants()
    {
        return $this->belongsToMany(User::class, 'registrations');
    }

    public function savedBy()
    {
        return $this->belongsToMany(User::class, 'saved_competitions')
                    ->withTimestamps();
    }

    /**
     * Get competition status based on registration_deadline
     */
    public function getStatusAttribute()
    {
        return $this->registration_deadline->isFuture() ? 'open' : 'closed';
    }
    
    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}