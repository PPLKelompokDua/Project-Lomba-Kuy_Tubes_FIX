<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamRecommendation extends Model
{
    protected $fillable = [
        'user_id',
        'role_recommendation',
        'strengths',
        'weaknesses',
        'compatibility_score'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}