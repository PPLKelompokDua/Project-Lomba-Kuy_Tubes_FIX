@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="mb-6">
        <a href="{{ route('articles.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Articles
        </a>
    </div>

    <article class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Article Header -->
        <div class="relative">
            @if ($article->thumbnail)
                <div class="relative h-80">
                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                </div>
                <div class="absolute bottom-0 left-0 p-6 text-white">
                    <div class="inline-block bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full mb-3">
                        {{ $article->category }}
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-white drop-shadow-sm">{{ $article->title }}</h1>
                </div>
            @else
                <div class="p-6 border-b">
                    <div class="inline-block bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full mb-3">
                        {{ $article->category }}
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">{{ $article->title }}</h1>
                </div>
            @endif
        </div>

        <!-- Article Meta -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center text-sm text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ $article->created_at->format('M d, Y') }}</span>
            </div>
            
            <div class="flex space-x-3">
                <button id="share-article" class="flex items-center text-gray-500 hover:text-indigo-600 transition" data-title="{{ $article->title }}" data-url="{{ request()->url() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                    Share
                </button>
            </div>
        </div>

        <!-- Article Content -->
        <div class="p-6 sm:p-8">
            <div class="prose max-w-none text-gray-800 leading-relaxed">
                {!! nl2br(e($article->body)) !!}
            </div>

            @if ($article->hashtags)
                <div class="mt-8 pt-6 border-t">
                    <div class="flex flex-wrap gap-2">
                        @foreach ($article->hashtags as $tag)
                            <span class="inline-flex items-center bg-indigo-50 text-indigo-700 text-sm font-medium px-3 py-1 rounded-full hover:bg-indigo-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                </svg>
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </article>

    <!-- Related Articles Section -->
    @if(isset($relatedArticles) && count($relatedArticles) > 0)
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Related Articles</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @foreach($relatedArticles as $relatedArticle)
                <a href="{{ route('articles.show', $relatedArticle->slug) }}" class="flex items-center space-x-4 p-4 bg-white rounded-lg shadow hover:shadow-md transition">
                    @if($relatedArticle->thumbnail)
                        <img src="{{ asset('storage/' . $relatedArticle->thumbnail) }}" alt="{{ $relatedArticle->title }}" class="h-16 w-16 object-cover rounded">
                    @else
                        <div class="h-16 w-16 bg-indigo-100 rounded flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h3 class="font-medium text-gray-800 line-clamp-2">{{ $relatedArticle->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $relatedArticle->created_at->format('M d, Y') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Share functionality
        const shareBtn = document.getElementById('share-article');
        if (shareBtn) {
            shareBtn.addEventListener('click', function() {
                const title = this.dataset.title;
                const url = this.dataset.url;
                
                if (navigator.share) {
                    navigator.share({
                        title: title,
                        url: url
                    })
                    .catch(error => console.log('Error sharing:', error));
                } else {
                    // Fallback for browsers that don't support the Web Share API
                    navigator.clipboard.writeText(url)
                        .then(() => {
                            // Show toast notification
                            showToast('Link copied to clipboard!');
                        })
                        .catch(err => console.log('Error copying text: ', err));
                }
            });
        }
        
        // Save article functionality (for demonstration)
        const saveBtn = document.getElementById('save-article');
        if (saveBtn) {
            saveBtn.addEventListener('click', function() {
                // Toggle saved state
                const isSaved = this.classList.contains('text-indigo-600');
                
                if (isSaved) {
                    this.classList.remove('text-indigo-600');
                    this.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />';
                    showToast('Article removed from saved items');
                } else {
                    this.classList.add('text-indigo-600');
                    this.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" fill="currentColor" />';
                    showToast('Article saved for later reading');
                }
            });
        }
        
        // Toast notification function
        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-opacity duration-300';
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 2500);
        }
    });
</script>
@endsection