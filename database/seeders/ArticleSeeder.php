<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Tips & Tricks', 'Motivation', 'Competition Stories', 'Technical Guides', 'Competition News'];

        for ($i = 1; $i <= 20; $i++) {
            $title = fake()->sentence(6);
            $body = collect(range(1, 5))->map(fn () => fake()->paragraph(5))->implode("\n\n");

            Article::create([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . Str::random(5),
                'user_id' => 1, // admin
                'category' => fake()->randomElement($categories),
                'status' => fake()->randomElement(['published', 'draft']),
                'excerpt' => Str::limit(strip_tags($body), 200),
                'body' => $body,
                'hashtags' => ['#' . fake()->word(), '#' . fake()->word()],
                'thumbnail' => "images/article" . rand(1, 5) . ".png",
            ]);
        }
    }
}
