<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackTim extends Model
{
    protected $table = 'feedback_tim';

    protected $fillable = [
        'tim_id',
        'user_id',
        'feedback',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
