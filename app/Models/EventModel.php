<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
{
    protected $table = 'event_competition';

    protected $fillable = [
        'title',
    ];

    public function feedbackEvent(){
        return $this->hasMany(FeedbackEvent::class, 'event_id');
    }
}
