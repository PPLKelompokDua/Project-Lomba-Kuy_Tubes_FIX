<?php

namespace App\Http\Controllers;

use App\Models\LearningVideo;
use Illuminate\Http\Request;

class LearningVideoController extends Controller
{
    /**
     * Display a listing of learning videos for students
     */
    public function index(Request $request)
    {
        // Start with all published videos
        $query = LearningVideo::where('is_published', true);
        
        // Apply category filter if specified
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }
        
        // Apply search if specified
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Get videos with ordering (featured first, then newest)
        $videos = $query->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->appends($request->all()); // Keep query parameters in pagination
            
        return view('learning-videos.index', compact('videos'));
    }

    /**
     * Display a specific learning video
     */
    public function show($id)
    {
        $video = LearningVideo::where('is_published', true)->findOrFail($id);
        
        // Get related videos (same category, excluding current video)
        $relatedVideos = LearningVideo::where('is_published', true)
            ->where('id', '!=', $video->id)
            ->where('category', $video->category)
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
            
        return view('learning-videos.show', compact('video', 'relatedVideos'));
    }
}
