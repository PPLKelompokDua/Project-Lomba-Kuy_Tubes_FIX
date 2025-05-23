<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewTugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'author',
        'start_date',
        'end_date',
        'team_id'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}