@extends('layouts.admin')

@section('title', 'Edit Learning Video')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-indigo-600 mb-2">Edit Learning Video</h1>
        <p class="text-gray-600">Update information for this learning video</p>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <form action="{{ route('admin.learning-videos.update', $video->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were errors with your submission:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            
            <div class="grid grid-cols-1 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Video Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $video->title) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md p-2" required>
                </div>
                
                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md p-2">{{ old('description', $video->description) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Brief description about what viewers will learn in this video</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Video URL -->
                    <div>
                        <label for="url" class="block text-sm font-medium text-gray-700 mb-1">Video URL <span class="text-red-500">*</span></label>
                        <input type="url" name="url" id="url" value="{{ old('url', $video->url) }}" placeholder="https://www.youtube.com/watch?v=..." class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md p-2" required>
                        <p class="mt-1 text-xs text-gray-500">YouTube or Vimeo URL</p>
                    </div>
                    
                    <!-- Thumbnail URL -->
                    <div>
                        <label for="thumbnail_url" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail URL</label>
                        <input type="url" name="thumbnail_url" id="thumbnail_url" value="{{ old('thumbnail_url', $video->thumbnail_url) }}" placeholder="https://example.com/image.jpg" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md p-2">
                        <p class="mt-1 text-xs text-gray-500">Leave blank to use video's default thumbnail</p>
                    </div>
                </div>
                
                <!-- Current Thumbnail Preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Current Thumbnail</label>
                    <div class="mt-1 flex items-center">
                        <div class="flex-shrink-0 w-32 h-20 border rounded overflow-hidden bg-gray-100 flex items-center justify-center">
                            @if($video->thumbnail_url)
                                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover" 
                                     onerror="this.onerror=null; this.src=''; this.classList.add('hidden'); this.parentElement.innerHTML += '<div class=\'flex items-center justify-center w-full h-full text-gray-500\'><svg xmlns=\'http://www.w3.org/2000/svg\' class=\'h-8 w-8\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z\' /></svg></div>';">
                            @else
                                <div class="flex items-center justify-center w-full h-full text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4 text-xs text-gray-500">
                            @if($video->thumbnail_url)
                                <p>URL: <a href="{{ $video->thumbnail_url }}" target="_blank" class="text-indigo-600 hover:underline">Lihat Gambar Asli</a></p>
                            @else
                                <p>Tidak ada thumbnail. Tambahkan URL untuk thumbnail.</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                        <select name="category" id="category" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md p-2" required>
                            <option value="" disabled>Select a category</option>
                            <option value="Programming" {{ old('category', $video->category) == 'Programming' ? 'selected' : '' }}>Programming</option>
                            <option value="Design" {{ old('category', $video->category) == 'Design' ? 'selected' : '' }}>Design</option>
                            <option value="Business" {{ old('category', $video->category) == 'Business' ? 'selected' : '' }}>Business</option>
                            <option value="Marketing" {{ old('category', $video->category) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                            <option value="Presentation" {{ old('category', $video->category) == 'Presentation' ? 'selected' : '' }}>Presentation</option>
                            <option value="Team Building" {{ old('category', $video->category) == 'Team Building' ? 'selected' : '' }}>Team Building</option>
                            <option value="Other" {{ old('category', $video->category) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    
                    <!-- Duration -->
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                        <input type="text" name="duration" id="duration" value="{{ old('duration', $video->duration) }}" placeholder="5:30" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md p-2">
                        <p class="mt-1 text-xs text-gray-500">Format: minutes:seconds (e.g. 5:30)</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Featured -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $video->is_featured) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_featured" class="font-medium text-gray-700">Featured Video</label>
                            <p class="text-gray-500">Featured videos appear prominently on the learning hub</p>
                        </div>
                    </div>
                    
                    <!-- Published -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $video->is_published) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_published" class="font-medium text-gray-700">Published</label>
                            <p class="text-gray-500">Uncheck to save as draft</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.learning-videos.index') }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back to Videos
                    </a>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.learning-videos.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                        </svg>
                        Update Video
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
