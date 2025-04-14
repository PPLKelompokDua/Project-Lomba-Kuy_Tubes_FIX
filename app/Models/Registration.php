<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'user_id',
        'competition_id',
        'status',
        'notes',
        'additional_data',
        'approved_at',
        'rejected_at'
    ];

    protected $casts = [
        'additional_data' => 'array',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    /**
     * Get the user that owns the registration.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the competition that owns the registration.
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
}
