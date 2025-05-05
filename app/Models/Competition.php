<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;
    protected $fillable = [
        'organizer_id',
        'title',
        'category',
        'description',
        'location',
        'start_date',
        'end_date',
        'registration_deadline',
        'max_participants',
        'image',
        'photo',
        'prize',
        'deadline',
        'registration_link',
        'external_registration_link',
        'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'registration_deadline' => 'datetime',
        'deadline' => 'datetime',
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
     * 
     * Using both competition_user and registrations tables for compatibility
     */
    public function participants()
    {
        // Menggunakan tabel registrations sesuai dengan fitur filter kategori
        return $this->belongsToMany(User::class, 'registrations');
    }
    
    /**
     * Alternative participants relationship using competition_user table
     */
    public function enrolledParticipants()
    {
        return $this->belongsToMany(User::class, 'competition_user');
    }

    /**
     * Get users who saved this competition
     */
    public function savedBy()
    {
        return $this->belongsToMany(User::class, 'saved_competitions')
                    ->withTimestamps();
    }

    /**
     * Get competition status based on deadline
     */
    public function getStatusAttribute()
    {
        if (isset($this->attributes['status'])) {
            return $this->attributes['status'];
        }
        return \Carbon\Carbon::parse($this->deadline)->isFuture() ? 'open' : 'closed';
    }
    
    /**
     * Get teams for this competition
     */
    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
