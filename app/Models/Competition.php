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

    public function savedBy()
    {
        return $this->belongsToMany(User::class, 'saved_competitions')
                    ->withTimestamps();
    }
}