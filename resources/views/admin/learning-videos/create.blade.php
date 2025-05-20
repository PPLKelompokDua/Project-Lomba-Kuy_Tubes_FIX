@extends('layouts.admin')

@section('title', 'Add New Learning Video')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-indigo-600 mb-2">Add New Learning Video</h1>
        <p class="text-gray-600">Create a new educational video for LombaKuy members</p>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <form action="{{ route('admin.learning-videos.store') }}" method="POST" class="p-6">
            @csrf
            
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
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md p-2" required>
                </div>
                
                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md p-2">{{ old('description') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Brief description about what viewers will learn in this video</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Video URL -->
                    <div>
                        <label for="url" class="block text-sm font-medium text-gray-700 mb-1">Video URL <span class="text-red-500">*</span></label>
                        <input type="url" name="url" id="url" value="{{ old('url') }}" placeholder="https://www.youtube.com/watch?v=..." class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md p-2" required>
                        <p class="mt-1 text-xs text-gray-500">YouTube or Vimeo URL</p>
                    </div>
                    
                    <!-- Thumbnail URL -->
                    <div>
                        <label for="thumbnail_url" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail URL</label>
                        <input type="url" name="thumbnail_url" id="thumbnail_url" value="{{ old('thumbnail_url') }}" placeholder="https://example.com/image.jpg" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md p-2">
                        <p class="mt-1 text-xs text-gray-500">Leave blank to use video's default thumbnail</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                        <select name="category" id="category" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md p-2" required>
                            <option value="" disabled selected>Select a category</option>
                            <option value="Tips Juara" {{ old('category') == 'Tips Juara' ? 'selected' : '' }}>Tips Juara</option>
                            <option value="Competition" {{ old('category') == 'Competition' ? 'selected' : '' }}>Competition</option>
                            <option value="Tutorial" {{ old('category') == 'Tutorial' ? 'selected' : '' }}>Tutorial</option>
                            <option value="Workshop" {{ old('category') == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                        </select>
                    </div>
                    
                    <!-- Duration -->
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                        <input type="text" name="duration" id="duration" value="{{ old('duration') }}" placeholder="5:30" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border rounded-md p-2">
                        <p class="mt-1 text-xs text-gray-500">Format: minutes:seconds (e.g. 5:30)</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Featured -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_featured" class="font-medium text-gray-700">Featured Video</label>
                            <p class="text-gray-500">Featured videos appear prominently on the learning hub</p>
                        </div>
                    </div>
                    
                    <!-- Published -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', '1') ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_published" class="font-medium text-gray-700">Publish Immediately</label>
                            <p class="text-gray-500">Uncheck to save as draft</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.learning-videos.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Create Learning Video
                </button>
            </div>
        </form>
    </div>
</div>
@endsection