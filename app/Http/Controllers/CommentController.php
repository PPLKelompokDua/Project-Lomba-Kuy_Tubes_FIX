<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;


class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim!');
    }

    public function fetch(Post $post)
    {
        return response()->json($post->comments()->with('user')->latest()->get());
    }
}
