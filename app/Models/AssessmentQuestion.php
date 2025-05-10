<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentQuestion extends Model
{
    protected $fillable = ['category', 'question'];

    public function options()
    {
        return $this->hasMany(AssessmentOption::class);
    }
}
