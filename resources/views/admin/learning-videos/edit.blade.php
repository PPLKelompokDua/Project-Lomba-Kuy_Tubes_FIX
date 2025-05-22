@extends('layouts.admin')

@section('title', 'Edit Learning Video')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold mb-6 text-indigo-600" data-aos="fade-up">Edit Learning Video</h1>

    <!-- Form Card -->
    <div class="bg-white p-6 rounded-lg shadow hover-rise" data-aos="fade-up" data-aos-delay="100">
        <div class="border-l-4 border-indigo-400 pl-4 mb-6">
            <h2 class="text-xl font-semibold text-indigo-700">Update Learning Video</h2>
        </div>

        <form action="{{ route('admin.learning-videos.update', $video->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded" data-aos="fade-up" data-aos-delay="150">
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
            
            <div class="mb-6" data-aos="fade-up" data-aos-delay="200">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Video Title <span class="text-red-500">*</span></label>
                <div class="relative">
                    <i class="fas fa-heading absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="title" id="title" value="{{ old('title', $video->title) }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg input-dynamic-border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Enter title" required>
                    @error('title')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-6" data-aos="fade-up" data-aos-delay="250">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <div class="relative">
                    <i class="fas fa-align-left absolute left-3 top-3 transform -translate-y-1/2 text-gray-400"></i>
                    <textarea name="description" id="description" rows="4" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg input-dynamic-border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Enter description">{{ old('description', $video->description) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Brief description about what viewers will learn in this video</p>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6" data-aos="fade-up" data-aos-delay="300">
                <div>
                    <label for="url" class="block text-sm font-medium text-gray-700 mb-1">Video URL <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-video absolute left-3 top-2.5 text-gray-400"></i>
                        <input type="url" name="url" id="url" value="{{ old('url', $video->url) }}" placeholder="https://www.youtube.com/watch?v=..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg input-dynamic-border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                        <p class="mt-1 text-xs text-gray-500">YouTube or Vimeo URL</p>
                        @error('url')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="thumbnail_url" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail URL</label>
                    <div class="relative">
                        <i class="fas fa-image absolute left-3 top-2.5 text-gray-400"></i>
                        <input type="url" name="thumbnail_url" id="thumbnail_url" value="{{ old('thumbnail_url', $video->thumbnail_url) }}" placeholder="https://example.com/image.jpg" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg input-dynamic-border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <p class="mt-1 text-xs text-gray-500">Leave blank to use video's default thumbnail</p>
                        @error('thumbnail_url')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-6" data-aos="fade-up" data-aos-delay="350">
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Thumbnail</label>
                <div class="mt-1 flex items-center">
                    <div class="flex-shrink-0 w-32 h-20 border rounded overflow-hidden bg-gray-100 flex items-center justify-center" id="thumbnail-container">
                        @if($video->thumbnail_url)
                            <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover" id="thumbnail-preview"
                                 onerror="this.style.display='none'; document.getElementById('thumbnail-placeholder').style.display='flex';">
                            <div id="thumbnail-placeholder" class="flex items-center justify-center w-full h-full text-gray-500" style="display: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6" data-aos="fade-up" data-aos-delay="400">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="fas fa-folder absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <select name="category" id="category" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg input-dynamic-border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition appearance-none bg-white" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Tips Juara" {{ old('category', $video->category) == 'Tips Juara' ? 'selected' : '' }}>Tips Juara</option>
                            <option value="Competition" {{ old('category', $video->category) == 'Competition' ? 'selected' : '' }}>Competition</option>
                            <option value="Tutorial" {{ old('category', $video->category) == 'Tutorial' ? 'selected' : '' }}>Tutorial</option>
                            <option value="Workshop" {{ old('category', $video->category) == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        @error('category')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                    <div class="relative">
                        <i class="fas fa-clock absolute left-3 top-2.5 text-gray-400"></i>
                        <input type="text" name="duration" id="duration" value="{{ old('duration', $video->duration) }}" placeholder="5:30" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg input-dynamic-border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <p class="mt-1 text-xs text-gray-500">Format: minutes:seconds (e.g. 5:30)</p>
                        @error('duration')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6" data-aos="fade-up" data-aos-delay="450">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $video->is_featured) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_featured" class="font-medium text-gray-700">Featured Video</label>
                        <p class="text-gray-500">Featured videos appear prominently on the learning hub</p>
                    </div>
                    @error('is_featured')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $video->is_published) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_published" class="font-medium text-gray-700">Published</label>
                        <p class="text-gray-500">Uncheck to save as draft</p>
                    </div>
                    @error('is_published')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between mt-8" data-aos="fade-up" data-aos-delay="500">
                <div>
                    <a href="{{ route('admin.learning-videos.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to Videos
                    </a>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.learning-videos.index') }}" class="inline-flex items-center bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Video
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<style>
    /* Card hover effects */
    .hover-rise {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-rise:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(79, 70, 229, 0.15);
    }
    
    /* Button hover glow */
    a, button[type="submit"] {
        position: relative;
    }
    
    a::after, button[type="submit"]::after {
        content: "";
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        background: linear-gradient(45deg, #4f46e5, #818cf8);
        z-index: -1;
        border-radius: 8px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    a:hover::after, button[type="submit"]:hover::after {
        opacity: 0.5;
    }
    
    /* Dynamic input border */
    .input-dynamic-border:not(:placeholder-shown) {
        border-color: #6366f1; /* indigo-500 */
    }
    
    /* Select styling */
    select {
        appearance: none;
        background-image: none;
        padding-right: 2.5rem; /* Adjust for custom arrow */
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        .max-w-7xl {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    // Initialize AOS
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true,
        });
    });
</script>
@endpush