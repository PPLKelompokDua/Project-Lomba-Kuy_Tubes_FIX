<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackEvent extends Model
{
    protected $table = 'feedback_event';
    protected $fillable = [
        'event_id',
        'user_id',
        'feedback',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
