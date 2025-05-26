@extends('layouts.admin')

@section('title', 'Add Article')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold mb-6 text-indigo-600" data-aos="fade-up">Add New Article</h1>

    <!-- Form Card -->
    <div class="bg-white p-6 rounded-lg shadow hover-rise" data-aos="fade-up" data-aos-delay="100">
        <div class="border-l-4 border-indigo-400 pl-4 mb-6">
            <h2 class="text-xl font-semibold text-indigo-700">Create New Article</h2>
        </div>

        <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-6" data-aos="fade-up" data-aos-delay="150">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                <div class="relative">
                    <i class="fas fa-heading absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input id="title" name="title" value="{{ old('title') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg input-dynamic-border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Enter title" required>
                    @error('title')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-6" data-aos="fade-up" data-aos-delay="200">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                <div class="relative">
                    <i class="fas fa-folder absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <select id="category" name="category" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg input-dynamic-border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition appearance-none bg-white" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach (['Tips & Tricks', 'Motivation', 'Competition Stories', 'Technical Guides', 'Competition News'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $article->category ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
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

            <div class="mb-6" data-aos="fade-up" data-aos-delay="250">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <div class="relative">
                    <i class="fas fa-check-square absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <select id="status" name="status" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg input-dynamic-border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition appearance-none bg-white" required>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-6" data-aos="fade-up" data-aos-delay="300">
                <label for="hashtags" class="block text-sm font-medium text-gray-700 mb-1">Hashtags (comma-separated)</label>
                <div class="relative">
                    <i class="fas fa-hashtag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input id="hashtags" name="hashtags" value="{{ old('hashtags') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg input-dynamic-border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Enter hashtags">
                    @error('hashtags')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-6" data-aos="fade-up" data-aos-delay="350">
                <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                <div class="relative">
                    <i class="fas fa-image absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="file" id="thumbnail" name="thumbnail" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg input-dynamic-border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('thumbnail')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-6" data-aos="fade-up" data-aos-delay="400">
                <label for="body" class="block text-sm font-medium text-gray-700 mb-1">Body <span class="text-red-500">*</span></label>
                <div class="relative">
                    <i class="fas fa-align-left absolute left-3 top-3 transform -translate-y-1/2 text-gray-400"></i>
                    <textarea id="body" name="body" rows="8" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg input-dynamic-border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" placeholder="Enter article body" required>{{ old('body') }}</textarea>
                    @error('body')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3" data-aos="fade-up" data-aos-delay="450">
                <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancel
                </a>
                <button dusk="submit-article" type="submit" class="inline-flex items-center bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Save
                </button>
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