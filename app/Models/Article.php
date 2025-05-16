<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'category',
        'status',
        'excerpt',
        'body',
        'thumbnail',
        'hashtags',
    ];

    protected $casts = [
        'hashtags' => 'array',
    ];

    // Auto-generate slug from title (optional helper)
    public static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    // Relasi ke User (Author)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
