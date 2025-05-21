<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentResult extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'result'];

    public function user()
    {
        return $this->belongsTo(User::class);
}
}