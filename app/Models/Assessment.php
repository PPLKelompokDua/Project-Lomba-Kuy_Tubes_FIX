<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'user_id',
        'personality_type',
        'preferred_role',
        'results',
        'total_score',
        'recommended_role',
        'strengths',
        'weaknesses',
        'compatibility_score',
        'work_style',
        'expertise',
        'experience_level',
        'communication_style',
        'availability',
        'last_completed_at'
    ];

    protected $casts = [
        'results' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}