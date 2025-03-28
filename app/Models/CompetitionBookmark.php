<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionBookmark extends Model
{
    use HasFactory;

    protected $table = 'competition_bookmarks'; // Pastikan sesuai dengan tabel di migration

    protected $fillable = [
        'user_id',
        'competition_id',
        'reminder_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
}
