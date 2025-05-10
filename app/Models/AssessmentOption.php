<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentOption extends Model
{
    protected $fillable = ['assessment_question_id', 'label', 'text'];

    public function question()
    {
        return $this->belongsTo(AssessmentQuestion::class);
    }
}
