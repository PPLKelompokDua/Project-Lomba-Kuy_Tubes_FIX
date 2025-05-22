@extends('layouts.admin')

@section('title', $video->title)

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Notifikasi Sukses -->
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md">
        <div class="flex items-center">
            <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p>{{ session('success') }}</p>
        </div>
    </div>
    @endif
    
    <!-- Top navigation and header section -->
    <div class="bg-white rounded-xl overflow-hidden">
        <div class="border-b border-gray-100 bg-gradient-to-r from-[#4f46e5] to-[#4f46e5] p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <a href="{{ route('admin.learning-videos.index') }}" class="inline-flex items-center text-sm text-white hover:text-gray-200 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to All Videos
                    </a>
                    <h1 class="text-3xl font-bold text-white mb-2">{{ $video->title }}</h1>
                    <div class="flex flex-wrap items-center gap-2 mt-3">
                    <span class="px-3 py-1 text-xs inline-flex items-center font-medium rounded-full bg-indigo-50 text-indigo-800 border border-indigo-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        {{ $video->category }}
                    </span>
                    @if($video->is_featured)
                    <span class="px-3 py-1 text-xs inline-flex items-center font-medium rounded-full bg-yellow-50 text-yellow-800 border border-yellow-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Featured
                    </span>
                    @endif
                    @if($video->is_published)
                    <span class="px-3 py-1 text-xs inline-flex items-center font-medium rounded-full bg-green-50 text-green-800 border border-green-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Published
                    </span>
                    @else
                    <span class="px-3 py-1 text-xs inline-flex items-center font-medium rounded-full bg-gray-50 text-gray-800 border border-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Draft
                    </span>
                    @endif
                    @if($video->duration)
                    <span class="px-3 py-1 text-xs inline-flex items-center font-medium rounded-full bg-blue-50 text-blue-800 border border-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $video->duration }}
                    </span>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Main content area with video and details -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 bg-white border border-gray-100 rounded-xl shadow-lg mt-6">
        <!-- Left Column: Video Player -->
        <div class="lg:col-span-8 space-y-6">
            <!-- Video Player with enhanced visuals -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white px-6 py-4">
                    <h2 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Video Preview
                    </h2>
                </div>
                <div class="aspect-video bg-gray-900 relative overflow-hidden">
                    @php
                        // Extract video ID from YouTube or Vimeo URL
                        $videoId = null;
                        $videoType = null;
                        
                        // YouTube URL formats:
                        // - https://www.youtube.com/watch?v=VIDEO_ID
                        // - https://youtu.be/VIDEO_ID
                        if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $video->url, $matches) || 
                            preg_match('/youtu\.be\/([^\/\?]+)/', $video->url, $matches)) {
                            $videoId = $matches[1];
                            $videoType = 'youtube';
                        }
                        // Vimeo URL formats:
                        // - https://vimeo.com/VIDEO_ID
                        elseif (preg_match('/vimeo\.com\/([0-9]+)/', $video->url, $matches)) {
                            $videoId = $matches[1];
                            $videoType = 'vimeo';
                        }
                    @endphp
                    
                    @if($videoType == 'youtube' && $videoId)
                        <iframe 
                            class="w-full h-full aspect-video" 
                            src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&modestbranding=1&color=white" 
                            title="{{ $video->title }}"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    @elseif($videoType == 'vimeo' && $videoId)
                        <iframe 
                            class="w-full h-full aspect-video" 
                            src="https://player.vimeo.com/video/{{ $videoId }}?title=0&byline=0&portrait=0&color=6366f1" 
                            title="{{ $video->title }}"
                            frameborder="0" 
                            allow="autoplay; fullscreen; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    @else
                        <div class="flex items-center justify-center p-12 bg-gradient-to-r from-gray-800 to-gray-900 aspect-video">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-indigo-300 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <p class="text-white text-lg mb-6">Embedded player not available for this video.</p>
                                <a href="{{ $video->url }}" target="_blank" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-gradient-to-r from-indigo-600 to-indigo-700 text-white hover:from-indigo-700 hover:to-indigo-800 transition shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    View on Original Site
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center text-sm text-gray-500">
                    <div>
                        <span class="inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            <a href="{{ $video->url }}" target="_blank" class="hover:text-indigo-600 truncate max-w-md">{{ $video->url }}</a>
                        </span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Added {{ $video->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Description and Action Buttons Side by Side -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white px-6 py-4">
                    <h2 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Description & Actions
                    </h2>
                </div>
                
                <div class="p-6 relative">
                    <!-- Decorative background element -->
                    <div class="absolute -right-20 -top-20 w-40 h-40 bg-indigo-50 rounded-full opacity-50 filter blur-3xl pointer-events-none"></div>
                    
                    @if($video->description)
                        <div class="prose prose-indigo max-w-none relative z-10">
                            {{ $video->description }}
                        </div>
                        <div class="mt-4 text-right">
                            <a href="{{ route('admin.learning-videos.edit', $video->id) }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit description
                            </a>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500 italic">No description available for this video.</p>
                            <a href="{{ route('admin.learning-videos.edit', $video->id) }}" class="mt-3 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Add a description
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Right Column: Video Information & Metadata -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Video Details -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white px-6 py-4">
                    <h2 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Video Information
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Simple Metadata Display -->
                    <div class="space-y-4">
                        <!-- Category -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-500">Category</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $video->category }}</p>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-500">Status</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $video->is_published ? 'Published' : 'Draft' }}</p>
                            </div>
                        </div>

                        <!-- Added On -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-500">Added On</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $video->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <!-- Last Updated -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-500">Last Updated</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $video->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Video URL Info -->
                    <div class="mt-4">
                        <h3 class="text-sm font-medium text-gray-500">Video URL</h3>
                        <div class="mt-1 flex items-center">
                            <a href="{{ $video->url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-sm truncate break-all">
                                {{ $video->url }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="bg-white rounded-xl overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                <div class="border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white px-6 py-4">
                    <h2 class="text-lg font-medium text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                        Actions
                    </h2>
                </div>
                <div class="p-6 space-y-3 bg-gradient-to-br from-white to-gray-50">
                    <a href="{{ route('admin.learning-videos.edit', $video->id) }}" class="w-full flex justify-center items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Video
                    </a>
                    
                    @if($video->is_published)
                    <form action="{{ route('admin.learning-videos.unpublish', $video->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full flex justify-center items-center px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-yellow-700 bg-white hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Unpublish Video
                        </button>
                    </form>
                    @else
                    <form action="{{ route('admin.learning-videos.publish', $video->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full flex justify-center items-center px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Publish Video
                        </button>
                    </form>
                    @endif
                    
                    <form action="{{ route('admin.learning-videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this video? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex justify-center items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete Video
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection