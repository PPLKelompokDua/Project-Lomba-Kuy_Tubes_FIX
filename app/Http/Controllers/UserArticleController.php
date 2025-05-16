<?php

namespace App\Http\Controllers;

use App\Models\Article;

class UserArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('status', 'published')
            ->latest()
            ->paginate(6);

        return view('article.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('article.show', compact('article'));
    }
}
