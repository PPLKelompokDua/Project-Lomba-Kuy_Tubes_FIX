<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $table = 'competitions'; // Pastikan sesuai dengan tabel di migration

    protected $fillable = [
        'title',
        'description',
        'category',
        'prize',
        'deadline',
        'registration_link',
        'organizer_id'
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function bookmarks()
    {
        return $this->hasMany(CompetitionBookmark::class);
    }
}
