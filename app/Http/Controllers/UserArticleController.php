<?php

namespace App\Http\Controllers;

use App\Models\Article;

class UserArticleController extends Controller
{
    public function index()
    {
        $search = request('search');

        $articles = Article::where('status', 'published')
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(6)
            ->appends(['search' => $search]); // agar pagination menyimpan keyword

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
