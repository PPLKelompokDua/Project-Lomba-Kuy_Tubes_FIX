<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'logo_url',
    ];

    /**
     * Get the users that belong to the team.
     */
    public function members()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the tasks that belong to the team.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the team leader.
     */
    public function leader()
    {
        return $this->hasOne(User::class)->where('role', 'team_leader');
    }
}