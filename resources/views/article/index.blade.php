@extends('layouts.app')

@section('title', 'Articles')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-indigo-600">Latest Articles</h1>
        <div class="relative">
            <form method="GET" action="{{ route('articles.index') }}" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..."
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 pr-10">
                <button type="submit" class="absolute right-3 top-2.5 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($articles as $article)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 flex flex-col">
                <div class="relative">
                    @if ($article->thumbnail)
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-52 object-cover">
                    @else
                        <div class="w-full h-52 bg-indigo-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3 bg-indigo-600 text-white text-xs font-semibold px-2 py-1 rounded-full">
                        {{ $article->category }}
                    </div>
                </div>
                
                <div class="p-5 flex-grow">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2 line-clamp-2 hover:text-indigo-600">{{ $article->title }}</h2>
                    <p class="text-sm text-gray-500 mb-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $article->created_at->format('M d, Y') }}
                    </p>
                    <p class="text-gray-700 text-sm mb-4 line-clamp-3">{{ $article->excerpt }}</p>
                </div>
                
                <div class="px-5 pb-5 mt-auto flex justify-between items-center">
                    <a href="{{ route('articles.show', $article->slug) }}" class="text-indigo-600 font-medium hover:text-indigo-800 transition">
                        Read more
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <div class="flex space-x-2">
                        <button class="share-btn p-2 text-gray-500 hover:text-indigo-600 transition" data-title="{{ $article->title }}" data-url="{{ route('articles.show', $article->slug) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-gray-600 text-lg font-medium">No articles available yet.</p>
                <p class="text-gray-500 mt-2">Check back later for new content!</p>
            </div>
        @endforelse
    </div>

    @if ($articles->hasPages())
        <div class="mt-8">
            {{ $articles->links('vendor.pagination.custom') }}
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Share functionality
        const shareBtns = document.querySelectorAll('.share-btn');
        shareBtns.forEach(btn => {
            btn.addEventListener('click', function() {
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
                    // Copy to clipboard
                    navigator.clipboard.writeText(url)
                        .then(() => {
                            // Show a temporary toast notification
                            const toast = document.createElement('div');
                            toast.className = 'fixed bottom-4 right-4 bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-lg';
                            toast.textContent = 'Link copied to clipboard!';
                            document.body.appendChild(toast);
                            
                            setTimeout(() => {
                                toast.remove();
                            }, 3000);
                        })
                        .catch(err => console.log('Error copying text: ', err));
                }
            });
        });
    });
</script>
@endsection