@extends('layouts.app')

@section('title', 'Competition Videos & Tips')

@section('content')
<div class="bg-gradient-to-b from-indigo-50 to-white min-h-screen pb-12">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12 mb-8">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl font-bold mb-4">Competition Videos & Tips</h1>
                <p class="text-indigo-100 text-lg mb-8">Watch helpful videos and get expert tips to improve your competition performance</p>
                
                <!-- Search Bar in Hero -->
                <form action="{{ route('learning-videos.index') }}" method="get">
                    <div class="relative max-w-2xl mx-auto">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Search for videos..." 
                            class="w-full px-6 py-4 rounded-full text-gray-800 shadow-lg focus:ring-2 focus:ring-indigo-400 focus:border-transparent"
                        >
                        <button type="submit" class="absolute right-3 top-3 bg-indigo-700 text-white p-2 rounded-full hover:bg-indigo-800 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="container mx-auto px-4">
        <!-- Category Filter Pills -->
        <div class="mb-8">
            <div class="flex flex-wrap justify-center gap-2">
                <a href="{{ route('learning-videos.index') }}" 
                   class="px-5 py-2 rounded-full {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} font-medium text-sm shadow-sm transition">
                    All Videos
                </a>
                <a href="{{ route('learning-videos.index', ['category' => 'Tips Juara', 'search' => request('search')]) }}" 
                   class="px-5 py-2 rounded-full {{ request('category') == 'Tips Juara' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} font-medium text-sm shadow-sm transition">
                    Tips Juara
                </a>
                <a href="{{ route('learning-videos.index', ['category' => 'Competition', 'search' => request('search')]) }}" 
                   class="px-5 py-2 rounded-full {{ request('category') == 'Competition' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} font-medium text-sm shadow-sm transition">
                    Competition
                </a>
                <a href="{{ route('learning-videos.index', ['category' => 'Tutorial', 'search' => request('search')]) }}" 
                   class="px-5 py-2 rounded-full {{ request('category') == 'Tutorial' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} font-medium text-sm shadow-sm transition">
                    Tutorial
                </a>
                <a href="{{ route('learning-videos.index', ['category' => 'Workshop', 'search' => request('search')]) }}" 
                   class="px-5 py-2 rounded-full {{ request('category') == 'Workshop' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} font-medium text-sm shadow-sm transition">
                    Workshop
                </a>
            </div>
        </div>
        
        <!-- Active Filters Display -->
        @if(request('search') || request('category'))
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="bg-indigo-50 rounded-lg px-4 py-2 flex items-center space-x-2">
                    <span class="text-indigo-800 font-medium text-sm">Active filters:</span>
                    @if(request('category'))
                        <span class="bg-white text-indigo-600 text-xs px-2 py-1 rounded-full flex items-center">
                            {{ request('category') }}
                            <a href="{{ route('learning-videos.index', array_merge(request()->except('category'), ['search' => request('search')])) }}" class="ml-1 text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        </span>
                    @endif
                    @if(request('search'))
                        <span class="bg-white text-indigo-600 text-xs px-2 py-1 rounded-full flex items-center">
                            "{{ request('search') }}"
                            <a href="{{ route('learning-videos.index', array_merge(request()->except('search'), ['category' => request('category')])) }}" class="ml-1 text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        </span>
                    @endif
                    
                    <a href="{{ route('learning-videos.index') }}" class="text-indigo-600 hover:text-indigo-800 text-xs font-medium ml-2">
                        Clear all
                    </a>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Results Count -->
        <div class="text-center mb-8">
            <p class="text-gray-600">
                {{ $videos->total() }} {{ Str::plural('video', $videos->total()) }} found
                @if(request('search') || request('category'))
                    for your search
                @endif
            </p>
        </div>
        
        <!-- Video Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($videos as $video)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition transform hover:-translate-y-1 group">
                    <a href="{{ route('learning-videos.show', $video->id) }}" class="block relative aspect-video bg-gray-200 overflow-hidden">
                        @if($video->thumbnail_url)
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-indigo-50 to-purple-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Category Badge -->
                        <div class="absolute top-2 left-2">
                            <span class="inline-block bg-black bg-opacity-60 text-white text-xs px-2 py-1 rounded-lg">
                                {{ $video->category }}
                            </span>
                        </div>
                        
                        <!-- Play Button -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                            <div class="w-16 h-16 rounded-full bg-indigo-600 bg-opacity-0 group-hover:bg-opacity-90 flex items-center justify-center transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                </svg>
                            </div>
                        </div>
                        
                        @if($video->duration)
                            <div class="absolute bottom-2 right-2 bg-black bg-opacity-70 text-white text-xs px-2 py-1 rounded">
                                {{ $video->duration }}
                            </div>
                        @endif
                        
                        @if($video->is_featured)
                            <div class="absolute top-2 right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded">
                                FEATURED
                            </div>
                        @endif
                    </a>
                    
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">
                            <a href="{{ route('learning-videos.show', $video->id) }}" class="hover:text-indigo-600 transition">
                                {{ $video->title }}
                            </a>
                        </h3>
                        @if($video->description)
                            <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                                {{ Str::limit($video->description, 100) }}
                            </p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center">
                    <div class="bg-white rounded-xl shadow-md p-8 max-w-md mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-indigo-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <h3 class="text-xl font-medium text-gray-800 mb-2">No videos found</h3>
                        <p class="text-gray-500 mb-6">We couldn't find any videos matching your criteria.</p>
                        <a href="{{ route('learning-videos.index') }}" class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Clear filters
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
            {{ $videos->links() }}
        </div>
    </div>
</div>
@endsection
