<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $fillable = [
        'organizer_id',
        'title',
        'description',
        'location',
        'start_date',
        'end_date',
        'registration_deadline',
        'max_participants',
        'image',
        'external_registration_link',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_deadline' => 'date',
    ];

    /**
     * Get the organizer that owns the competition.
     */
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    /**
     * Get the participants (users) registered for this competition.
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'registrations');
    }
}
