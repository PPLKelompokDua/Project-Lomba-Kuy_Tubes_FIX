<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningVideo;
use Illuminate\Support\Facades\Validator;

class LearningVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = LearningVideo::latest()->paginate(10);
        return view('admin.learning-videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.learning-videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url',
            'thumbnail_url' => 'nullable|url',
            'category' => 'required|string|max:50',
            'duration' => 'nullable|string|max:20',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('admin.learning-videos.create')
                ->withErrors($validator)
                ->withInput();
        }
        
        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');
        $data['is_published'] = $request->has('is_published');
        
        LearningVideo::create($data);
        
        return redirect()->route('admin.learning-videos.index')
            ->with('success', 'Learning video successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $video = LearningVideo::findOrFail($id);
        return view('admin.learning-videos.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $video = LearningVideo::findOrFail($id);
        return view('admin.learning-videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'required|url',
            'thumbnail_url' => 'nullable|url',
            'category' => 'required|string|max:50',
            'duration' => 'nullable|string|max:20',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('admin.learning-videos.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }
        
        $video = LearningVideo::findOrFail($id);
        
        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');
        $data['is_published'] = $request->has('is_published');
        
        $video->update($data);
        
        return redirect()->route('admin.learning-videos.index')
            ->with('success', 'Learning video successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = LearningVideo::findOrFail($id);
        $video->delete();
        
        return redirect()->route('admin.learning-videos.index')
            ->with('success', 'Learning video successfully deleted!');
    }
}
