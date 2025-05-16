<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // 1. Tampilkan daftar artikel
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    // 2. Form tambah artikel
    public function create()
    {
        return view('admin.articles.create');
    }

    // 3. Simpan artikel baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'category' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'hashtags' => 'nullable|string', // comma-separated
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'user_id' => Auth::id(),
            'category' => $request->category,
            'status' => $request->status,
            'excerpt' => Str::limit(strip_tags($request->body), 200),
            'body' => $request->body,
            'thumbnail' => $thumbnailPath,
            'hashtags' => $request->hashtags 
                ? array_map('trim', explode(',', $request->hashtags))
                : [],
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Article has been successfully added.');
    }

    // 4. Lihat detail artikel
    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    // 5. Form edit artikel
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    // 6. Update artikel
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'category' => 'nullable|string|max:100',
            'status' => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'hashtags' => 'nullable|string',
        ]);

        $data = $request->only('title', 'body', 'category', 'status');
        $data['excerpt'] = Str::limit(strip_tags($request->body), 200);
        $data['slug'] = Str::slug($request->title);
        $data['hashtags'] = $request->hashtags
            ? array_map('trim', explode(',', $request->hashtags))
            : [];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Article has been successfully updated.');
    }

    // 7. Hapus artikel
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Article has been successfully deleted.');
    }
}
