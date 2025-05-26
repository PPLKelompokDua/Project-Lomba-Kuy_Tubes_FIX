<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->sentence),
            'user_id' => \App\Models\User::factory(),
            'category' => 'Motivation',
            'status' => 'published',
            'excerpt' => $this->faker->text(100),
            'body' => $this->faker->paragraph,
            'thumbnail' => null,
            'hashtags' => ['#test', '#dusk'],
        ];
    }
}
