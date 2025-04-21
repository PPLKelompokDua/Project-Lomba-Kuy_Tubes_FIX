@extends('layouts.app')

@section('title', 'Edit Competition')

@section('content')
<!-- Page header -->
<div class="mb-8">
    <div class="flex items-center">
        <a href="{{ route('competitions.show', $competition->id) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition duration-150 ease-in-out group mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 group-hover:-translate-x-1 transition-transform duration-150 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Competition
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Competition</h1>
    </div>
</div>

<!-- Form card -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="p-6">
        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="bi bi-exclamation-triangle text-red-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('competitions.update', $competition->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Competition basic information -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Competition Title</label>
                        <input type="text" class="w-full px-3 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror" 
                               id="title" name="title" value="{{ old('title', $competition->title) }}" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" class="w-full px-3 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('location') border-red-500 @enderror" 
                               id="location" name="location" value="{{ old('location', $competition->location) }}" required>
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Competition dates -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Important Dates</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" class="w-full px-3 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('start_date') border-red-500 @enderror" 
                               id="start_date" name="start_date" value="{{ old('start_date', $competition->start_date->format('Y-m-d')) }}" required>
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" class="w-full px-3 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('end_date') border-red-500 @enderror" 
                               id="end_date" name="end_date" value="{{ old('end_date', $competition->end_date->format('Y-m-d')) }}" required>
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="registration_deadline" class="block text-sm font-medium text-gray-700 mb-1">Registration Deadline</label>
                        <input type="date" class="w-full px-3 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('registration_deadline') border-red-500 @enderror" 
                               id="registration_deadline" name="registration_deadline" value="{{ old('registration_deadline', $competition->registration_deadline->format('Y-m-d')) }}" required>
                        @error('registration_deadline')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Competition details -->
            <div class="mb-8">
                <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Competition Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-1">Maximum Participants</label>
                        <input type="number" class="w-full px-3 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('max_participants') border-red-500 @enderror" 
                               id="max_participants" name="max_participants" value="{{ old('max_participants', $competition->max_participants) }}">
                        <p class="mt-1 text-xs text-gray-500">Leave empty for unlimited participants</p>
                        @error('max_participants')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select class="w-full px-3 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror" 
                                id="status" name="status" required>
                            <option value="open" {{ old('status', $competition->status) == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ old('status', $competition->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="completed" {{ old('status', $competition->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea class="w-full px-3 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror" 
                              id="description" name="description" rows="5" required>{{ old('description', $competition->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Competition Image</label>
                    @if($competition->image)
                    <div class="mb-3 border p-2 rounded-lg bg-gray-50">
                        <img src="{{ asset('storage/' . $competition->image) }}" alt="{{ $competition->title }}" class="rounded-lg max-h-48 mx-auto">
                        <p class="mt-2 text-xs text-gray-500 text-center">Current image. Upload a new one to replace it.</p>
                    </div>
                    @endif
                    <input type="file" class="w-full px-3 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('image') border-red-500 @enderror" 
                           id="image" name="image">
                    <p class="mt-1 text-xs text-gray-500">Upload a new image for your competition (max size: 2MB)</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="external_registration_link" class="block text-sm font-medium text-gray-700 mb-1">External Registration Link</label>
                    <input type="url" class="w-full px-3 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('external_registration_link') border-red-500 @enderror" 
                           id="external_registration_link" name="external_registration_link" value="{{ old('external_registration_link', $competition->external_registration_link) }}" required>
                    <p class="mt-1 text-xs text-gray-500">Provide an external URL where participants can register for this competition</p>
                    @error('external_registration_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('competitions.show', $competition->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 ease-in-out">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150 ease-in-out">
                    <i class="bi bi-check-circle mr-2"></i> Update Competition
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
