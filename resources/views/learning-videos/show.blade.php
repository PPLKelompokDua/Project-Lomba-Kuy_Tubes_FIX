@extends('layouts.app')

@section('title', $video->title)

@section('content')
<div class="bg-gradient-to-b from-indigo-50 via-white to-white min-h-screen">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Hero Section with Video Info -->
        <div class="relative mb-8 overflow-hidden bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl shadow-xl transform hover:scale-[1.01] transition-all duration-300">
            <!-- Decorative elements -->
            <div class="absolute inset-0 overflow-hidden opacity-10">
                <svg class="absolute right-0 top-0" width="400" height="400" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#FFFFFF" d="M38.9,-66.7C50.5,-58.5,60.2,-48.1,67.8,-35.8C75.3,-23.5,80.7,-9.4,79.9,4.6C79.1,18.6,72.1,32.5,63.3,44.2C54.5,55.9,43.9,65.3,31.7,69.2C19.4,73.1,5.4,71.5,-9.2,70.8C-23.9,70.1,-39.3,70.3,-51.5,64.4C-63.7,58.5,-72.8,46.5,-79.2,33C-85.7,19.4,-89.5,4.3,-87.9,-10.3C-86.3,-24.9,-79.2,-39,-68.8,-49.6C-58.3,-60.3,-44.4,-67.6,-30.7,-74.2C-17,-80.7,-3.5,-86.6,8.2,-80.8C19.9,-75.1,39.8,-57.7,38.9,-66.7Z" transform="translate(100 100)" />
                </svg>
            </div>
            <div class="absolute -left-16 -bottom-16 w-64 h-64 bg-indigo-500 rounded-full filter blur-3xl opacity-20"></div>
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-purple-500 rounded-full filter blur-3xl opacity-20"></div>
            
            <div class="relative p-6 md:p-10 z-10">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-4">
                    <a href="{{ route('learning-videos.index') }}" class="inline-flex items-center space-x-2 text-white hover:text-indigo-100 font-medium transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Back to Videos</span>
                    </a>
                    
                    <div class="flex items-center space-x-2 flex-wrap">
                        <a href="{{ route('learning-videos.index', ['category' => $video->category]) }}" 
                           class="inline-flex items-center text-xs font-medium px-3 py-1.5 text-white hover:text-indigo-100 transition-all transform hover:scale-105 m-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            {{ $video->category }}
                        </a>
                        
                        @if($video->duration)
                        <span class="inline-flex items-center text-xs font-medium px-3 py-1.5 text-white m-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $video->duration }}
                        </span>
                        @endif
                        
                        @if($video->is_featured)
                        <span class="inline-flex items-center text-xs font-medium px-3 py-1.5 text-yellow-100 m-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            Featured
                        </span>
                        @endif
                    </div>
                </div>
                
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-2 mt-4 tracking-tight">{{ $video->title }}</h1>
                
                <!-- Add video author/source if available -->
                @if($video->author)
                <p class="text-indigo-100 text-sm md:text-base">{{ $video->author }}</p>
                @endif
            </div>
        </div>
    
    <!-- Main content section with side-by-side layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column (2/3) - Video Player -->
        <div class="lg:col-span-2">
            <!-- Video Player with Enhanced UI -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 transform hover:shadow-2xl transition-all duration-300">
                <div class="p-0">
                    <div class="rounded-none overflow-hidden bg-black aspect-video relative">
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
                            <div class="aspect-video">
                                <iframe 
                                    class="w-full h-full" 
                                    src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&modestbranding=1&color=white" 
                                    title="{{ $video->title }}"
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @elseif($videoType == 'vimeo' && $videoId)
                            <div class="aspect-video">
                                <iframe 
                                    class="w-full h-full" 
                                    src="https://player.vimeo.com/video/{{ $videoId }}?title=0&byline=0&portrait=0&color=6366f1" 
                                    title="{{ $video->title }}"
                                    frameborder="0" 
                                    allow="autoplay; fullscreen; picture-in-picture" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @else
                            <div class="flex items-center justify-center p-16 bg-gradient-to-r from-gray-800 to-gray-900">
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-indigo-400 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-white text-xl mb-6">Embedded player not available for this video.</p>
                                    <a href="{{ $video->url }}" target="_blank" class="inline-flex items-center px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 text-white hover:from-indigo-700 hover:to-indigo-800 transition shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        Watch on Original Site
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column (1/3) - About This Video -->
        <div class="lg:col-span-1">
            <!-- Video Description -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8 transform hover:shadow-xl transition-all duration-300">
                <div class="relative overflow-hidden">
                    <div class="absolute -right-20 -top-20 w-40 h-40 bg-indigo-100 rounded-full filter blur-xl opacity-70"></div>
                    <div class="p-6 relative">
                        <div class="flex items-center mb-6">
                            <div class="p-3 bg-gradient-to-br from-indigo-100 to-indigo-50 rounded-lg mr-4 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">About this video</h2>
                        </div>
                        
                        @if($video->description)
                            <div class="prose text-gray-700 mb-6 max-w-none">
                                {{ $video->description }}
                            </div>
                        @else
                            <div class="bg-indigo-50 rounded-xl p-4 text-center mb-6">
                                <p class="text-gray-500 italic">No description available for this video.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Video Metadata -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8 transform hover:shadow-xl transition-all duration-300">
                <div class="p-6 bg-gradient-to-br from-gray-50 to-white">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-md font-medium text-gray-700">Video Details</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-4">
                        @if($video->duration)
                        <div class="flex items-center bg-gray-50 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500">Duration</p>
                                <p class="text-sm font-medium">{{ $video->duration }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($video->created_at)
                        <div class="flex items-center bg-gray-50 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500">Added On</p>
                                <p class="text-sm font-medium">{{ $video->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Sidebar with Related Videos -->        
            @if($relatedVideos && $relatedVideos->count() > 0)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 sticky top-8 border border-gray-100 transform hover:shadow-2xl hover:scale-[1.01] transition-all duration-300">
                <!-- Header with decorative elements -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5 relative overflow-hidden">
                    <!-- Decorative patterns -->
                    <div class="absolute -right-8 -top-8 w-16 h-16 bg-white bg-opacity-10 rounded-full"></div>
                    <div class="absolute -left-4 bottom-0 w-24 h-24 bg-purple-500 bg-opacity-20 rounded-full filter blur-xl"></div>
                    
                    <h2 class="text-lg font-bold text-white flex items-center relative z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                        </svg>
                        Related Videos
                    </h2>
                </div>
                
                <!-- Video List with enhanced styling -->
                <div class="divide-y divide-gray-100 max-h-[70vh] overflow-y-auto custom-scrollbar">
                    @foreach($relatedVideos as $relatedVideo)
                    <a href="{{ route('learning-videos.show', $relatedVideo->id) }}" class="block group hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all duration-300">
                        <div class="p-4 flex space-x-3">
                            <div class="flex-shrink-0 relative w-24 h-16 bg-gray-100 rounded-lg overflow-hidden shadow-sm transform group-hover:scale-105 transition-all duration-300">
                                @if($relatedVideo->thumbnail_url)
                                    <img src="{{ $relatedVideo->thumbnail_url }}" alt="{{ $relatedVideo->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-50 to-purple-50 text-indigo-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Category badge -->
                                <div class="absolute top-1 left-1">
                                    <span class="inline-block bg-black bg-opacity-60 text-white text-[10px] px-1.5 py-0.5 rounded">
                                        {{ $relatedVideo->category }}
                                    </span>
                                </div>
                                
                                <!-- Play Overlay -->
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                    <div class="w-8 h-8 rounded-full bg-indigo-600 bg-opacity-0 group-hover:bg-opacity-90 flex items-center justify-center transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        </svg>
                                    </div>
                                </div>
                                
                                @if($relatedVideo->duration)
                                    <div class="absolute bottom-1 right-1 bg-black bg-opacity-70 text-white text-[10px] px-1.5 py-0.5 rounded">
                                        {{ $relatedVideo->duration }}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-grow">
                                <h3 class="text-sm font-medium text-gray-800 group-hover:text-indigo-700 transition-colors line-clamp-2 mb-1">
                                    {{ $relatedVideo->title }}
                                </h3>
                                @if($relatedVideo->description)
                                <p class="text-xs text-gray-500 line-clamp-1">
                                    {{ Str::limit($relatedVideo->description, 60) }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                
                <!-- Footer with View All button -->
                <div class="p-4 text-center bg-gradient-to-b from-white to-gray-50 border-t border-gray-100">
                    <a href="{{ route('learning-videos.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-full shadow-md transform hover:scale-105 transition-all">
                        View All Videos
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Add custom scrollbar styling -->
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 100vh;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c7d2fe;
            border-radius: 100vh;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a5b4fc;
        }
    </style>
</div>
@endsection
