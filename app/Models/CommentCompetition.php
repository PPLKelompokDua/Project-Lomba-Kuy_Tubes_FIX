<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentCompetition extends Model
{
    protected $table = 'comment_competition';
    protected $fillable = ['comment', 'post_competition_id', 'user_id' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
