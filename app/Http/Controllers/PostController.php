<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;
    
    public function index()
    {
        $posts = Post::with(['user', 'comments.user'])->latest()->paginate(10);
        return view('story.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'required|string',
            'media' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,mp4|max:2048',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'caption' => $request->caption,
        ];

        if ($request->hasFile('media')) {
            $data['media'] = $request->file('media')->store('posts', 'public');
        }

        Post::create($data);

        return redirect()->route('posts.index')->with('success', 'Post berhasil dibuat!');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'caption' => 'required|string',
            'media' => 'nullable|image|max:2048',
        ]);

        $data = ['caption' => $request->caption];

        if ($request->hasFile('media')) {
            $data['media'] = $request->file('media')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Post berhasil diperbarui!');
    }
}
