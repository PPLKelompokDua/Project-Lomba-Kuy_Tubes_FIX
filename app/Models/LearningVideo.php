<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningVideo extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'url',
        'thumbnail_url',
        'category',
        'duration',
        'is_featured',
        'is_published',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];
}