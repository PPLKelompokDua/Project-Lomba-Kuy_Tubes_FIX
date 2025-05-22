<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'competition_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
        'is_done'
    ];


    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Relasi: Milestone dimiliki oleh satu kompetisi.
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function milestones() {
    return $this->hasMany(CompetitionMilestone::class);
}
}
